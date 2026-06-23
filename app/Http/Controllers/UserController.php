<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::with('roles');

            return DataTables::of($users)
                ->addIndexColumn()

                ->addColumn('roles', function ($user) {
                    return $user->roles->map(function ($role) {
                        return '<span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 mr-1">'
                            . $role->name .
                            '</span>';
                    })->implode(' ');
                })

                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('d M Y');
                })

                ->addColumn('action', function ($user) {

                    $deleteButton = '';

                    if ($user->id !== auth()->id()) {
                        $deleteButton = '
            <form action="' . route('admin.users.destroy', $user) . '" method="POST"
                  onsubmit="return confirm(\'Yakin ingin menghapus user ini?\')">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '

                <button type="submit"
                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-600">
                    🗑️
                </button>
            </form>
        ';
                    }

                    return '
        <div class="flex gap-2">

            <a href="' . route('admin.users.edit', $user) . '"
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                ✏️
            </a>

            ' . $deleteButton . '

        </div>
    ';
                })

                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'password' => 'required|min:6',
        ]);

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);
        } catch (\Exception $e) {

            dd($e->getMessage());
        }
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // sync role (Spatie Permission)
        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Mencegah user menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
