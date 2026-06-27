<?php

namespace App\Http\Controllers;

use App\Models\ac_types;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AcTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ac_types::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                            <div class="flex items-center justify-center gap-2">
                                <a href="'.route('admin.ac-types.edit', $row->id).'"
                                    class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700
                                    hover:bg-amber-100 text-xs font-medium border border-amber-100 transition">
                                    Edit
                                </a>
                                <form method="POST" action="'.route('admin.ac-types.destroy', $row->id).'">
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

        return view('admin.ac-types.index');
    }

    public function create()
    {
        $kode = ac_types::generateKode();

        return view('admin.ac-types.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
        ]);

        $type = ac_types::create([
            'kode' => ac_types::generateKode(),
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($type)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcType',
            ])
            ->log('Menambahkan tipe AC baru');

        return redirect()
            ->route('admin.ac-types.index')
            ->with('success', 'Tipe AC berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $type = ac_types::findOrFail($id);

        return view('admin.ac-types.edit', compact('type'));
    }

    public function update(Request $request, ac_types $ac_type)
    {
        $request->validate([
            'nama' => 'required|max:255',
        ]);

        $ac_type->update($request->only([
            'nama',
            'keterangan',
        ]));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($ac_type)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcType',
            ])
            ->log('Mengupdate data tipe AC');

        return redirect()
            ->route('admin.ac-types.index')
            ->with('success', 'Tipe AC berhasil diperbarui');
    }

    public function destroy(ac_types $ac_type, Request $request)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($ac_type)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcType',
            ])
            ->log('Menghapus data tipe AC');

        $ac_type->delete();

        return back()->with(
            'success',
            'Tipe AC berhasil dihapus'
        );
    }
}
