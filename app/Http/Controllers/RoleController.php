<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $roles = Role::with('permissions')
                ->withCount('users');

            return DataTables::of($roles)
                ->addIndexColumn()

                ->addColumn('permissions_count', function ($role) {

                    return '<span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
            ' . $role->permissions->count() . ' Permission
        </span>';
                })

                ->addColumn('users_count', function ($role) {
                    return $role->users_count;
                })

                ->editColumn('created_at', function ($role) {
                    return $role->created_at->format('d M Y');
                })

                ->addColumn('action', function ($role) {

                    $showUrl = route('admin.roles.show', $role);
                    $editUrl = route('admin.roles.edit', $role);
                    $deleteUrl = route('admin.roles.destroy', $role);

                    return '
            <div class="flex items-center gap-2">

                <a href="' . $showUrl . '"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 transition">
                    👁
                </a>

                <a href="' . $editUrl . '"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition">
                    ✏️
                </a>

                <a href="' . $deleteUrl . '"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition">
                    delete
                </a>
            </div>
        ';
                })

                ->rawColumns([
                    'permissions_count',
                    'action'
                ])

                ->make(true);
        }

        return view('admin.roles.index', [
            'totalRoles' => Role::count(),
            'totalPermissions' => Permission::count(),
            'totalUsers' => User::count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()
            ->groupBy(function ($permission) {

                return explode('.', $permission->name)[0];
            });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->event('create')
            ->withProperties([
                'role_id' => $role->id,
                'role_name' => $role->name,
                'permission_count' => count($request->permissions ?? []),
                'permissions' => $request->permissions ?? [],
                'ip' => $request->ip(),
            ])
            ->log("Membuat role {$role->name}");

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()
            ->groupBy(function ($permission) {

                return explode('.', $permission->name)[0];
            });

        return view(
            'admin.roles.edit',
            compact(
                'role',
                'permissions'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->event('update')
            ->withProperties([
                'role_id' => $role->id,
                'role_name' => $role->name,
                'permission_count' => count($request->permissions ?? []),
                'permissions' => $request->permissions ?? [],
                'ip' => $request->ip(),
            ])
            ->log("Memperbarui role {$role->name}");

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, [
            'Owner',
            'Admin'
        ])) {

            return back()->with(
                'error',
                'Role sistem tidak dapat dihapus.'
            );
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->event('delete')
            ->withProperties([
                'role_name' => $role->name,
                'ip' => request()->ip(),
            ])
            ->log("Menghapus role {$role->name}");

        $role->delete();

        return back()->with(
            'success',
            'Role berhasil dihapus.'
        );
    }
}
