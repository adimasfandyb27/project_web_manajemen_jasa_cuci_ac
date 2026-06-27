<?php

namespace App\Http\Controllers;

use App\Models\ac_capacities;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AcCapacityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ac_capacities::query())
                ->addIndexColumn()
                ->addColumn('pk_formatted', function ($row) {
                    return number_format($row->pk, 1, ',', '.').' PK';
                })
                ->addColumn('action', function ($row) {
                    return '
                            <div class="flex items-center justify-center gap-2">
                                <a href="'.route('admin.ac-capacities.edit', $row->id).'"
                                    class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700
                                    hover:bg-amber-100 text-xs font-medium border border-amber-100 transition">
                                    Edit
                                </a>
                                <form method="POST" action="'.route('admin.ac-capacities.destroy', $row->id).'">
                                    '.csrf_field().method_field('DELETE').'
                                    <button onclick="return confirm(\'Yakin hapus?\')"
                                        class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600
                                        hover:bg-red-100 text-xs font-medium border border-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.ac-capacities.index');
    }

    public function create()
    {
        return view('admin.ac-capacities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pk' => 'required|numeric',
            'label' => 'required|max:255',
        ]);

        $capacity = ac_capacities::create([
            'pk' => $request->pk,
            'label' => $request->label,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($capacity)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcCapacity',
            ])
            ->log('Menambahkan kapasitas AC baru');

        return redirect()
            ->route('admin.ac-capacities.index')
            ->with('success', 'Kapasitas AC berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $capacity = ac_capacities::findOrFail($id);

        return view('admin.ac-capacities.edit', compact('capacity'));
    }

    public function update(Request $request, ac_capacities $ac_capacity)
    {
        $request->validate([
            'pk' => 'required|numeric',
            'label' => 'required|max:255',
        ]);

        $ac_capacity->update($request->only([
            'pk',
            'label',
        ]));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($ac_capacity)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcCapacity',
            ])
            ->log('Mengupdate data kapasitas AC');

        return redirect()
            ->route('admin.ac-capacities.index')
            ->with('success', 'Kapasitas AC berhasil diperbarui');
    }

    public function destroy(ac_capacities $ac_capacity, Request $request)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($ac_capacity)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcCapacity',
            ])
            ->log('Menghapus data kapasitas AC');

        $ac_capacity->delete();

        return back()->with(
            'success',
            'Kapasitas AC berhasil dihapus'
        );
    }
}
