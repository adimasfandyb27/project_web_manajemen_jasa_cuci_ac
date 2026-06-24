<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Technician::query())
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status == 'aktif'
                        ? '<span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Aktif</span>'
                        : '<span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Nonaktif</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                    <div class="flex gap-2 justify-center">
                        <a href="' . route('admin.technicians.edit', $row) . '" class="px-3 py-2 rounded-xl bg-amber-100 text-amber-700 text-sm font-medium">Edit</a>

                        <form action="' . route('admin.technicians.destroy', $row) . '" method="POST" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="px-3 py-2 rounded-xl bg-red-100 text-red-700 text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                ';
                })
                ->rawColumns(['status', 'aksi'])
                ->make(true);
        }

        return view('admin.technicians.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_teknisi = Technician::generateKode();
        return view('admin.technicians.create', compact('kode_teknisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
        ]);

        $technician = Technician::create([
            'kode_teknisi' => Technician::generateKode(),
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'status' => $request->status ?? 'aktif',
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($technician)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Technician',
            ])
            ->log('Menambahkan Teknisi baru');

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Teknisi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $technician = Technician::findOrFail($id);

        return view('admin.technicians.edit', compact('technician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $technician->update($request->all());

        activity()
            ->causedBy(auth()->user())
            ->performedOn($technician)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Technician',
            ])
            ->log('Mengupdate data teknisi');

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Teknisi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician , Request $request)
    {
        if ($technician->serviceOrders()->exists()) {
            return back()->with(
                'error',
                'Teknisi tidak dapat dihapus karena sudah digunakan pada transaksi service.'
            );
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($technician)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Technician',
            ])
            ->log('Menghapus data teknisi');

        $technician->delete(); // lebih disarankan daripada forceDelete()

        return back()->with(
            'success',
            'Teknisi berhasil dihapus.'
        );
    }
}
