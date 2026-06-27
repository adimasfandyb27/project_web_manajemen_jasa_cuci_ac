<?php

namespace App\Http\Controllers;

use App\Models\ac_brands;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AcBrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ac_brands::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                            <div class="flex items-center justify-center gap-2">
                                <a href="'.route('admin.ac-brands.edit', $row->id).'"
                                    class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700
                                    hover:bg-amber-100 text-xs font-medium border border-amber-100 transition">
                                    Edit
                                </a>
                                <form method="POST" action="'.route('admin.ac-brands.destroy', $row->id).'">
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

        return view('admin.ac-brands.index');
    }

    public function create()
    {
        $kode = ac_brands::generateKode();

        return view('admin.ac-brands.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
        ]);

        $brand = ac_brands::create([
            'kode' => ac_brands::generateKode(),
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($brand)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcBrand',
            ])
            ->log('Menambahkan merek AC baru');

        return redirect()
            ->route('admin.ac-brands.index')
            ->with('success', 'Merek AC berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $brand = ac_brands::findOrFail($id);

        return view('admin.ac-brands.edit', compact('brand'));
    }

    public function update(Request $request, ac_brands $ac_brand)
    {
        $request->validate([
            'nama' => 'required|max:255',
        ]);

        $ac_brand->update($request->only([
            'nama',
            'keterangan',
        ]));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($ac_brand)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcBrand',
            ])
            ->log('Mengupdate data merek AC');

        return redirect()
            ->route('admin.ac-brands.index')
            ->with('success', 'Merek AC berhasil diperbarui');
    }

    public function destroy(ac_brands $ac_brand, Request $request)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($ac_brand)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'AcBrand',
            ])
            ->log('Menghapus data merek AC');

        $ac_brand->delete();

        return back()->with(
            'success',
            'Merek AC berhasil dihapus'
        );
    }
}
