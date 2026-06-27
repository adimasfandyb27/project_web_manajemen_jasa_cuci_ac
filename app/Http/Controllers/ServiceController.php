<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Service::query())
                ->addIndexColumn()
                ->addColumn('harga_formatted', function ($row) {
                    return 'Rp '.number_format($row->harga, 0, ',', '.');
                })

                ->addColumn('action', function ($row) {
                    return '
                            <div class="flex items-center justify-center gap-2">

                                <a href="'.route('admin.services.edit', $row->id).'"
                                    class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700
                                    hover:bg-amber-100 text-xs font-medium border border-amber-100 transition">
                                    Edit
                                </a>

                                <form method="POST" action="'.route('admin.services.destroy', $row->id).'">
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

        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_layanan = Service::generateKode();

        // dd($kode_layanan);
        return view('admin.services.create', compact('kode_layanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required|numeric',
        ]);

        $service = Service::create([
            'kode_layanan' => Service::generateKode(),
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($service)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Service',
            ])
            ->log('Menambahkan layanan baru');

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan');
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
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $service->update($request->all());

        activity()
            ->causedBy(auth()->user())
            ->performedOn($service)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Service',
            ])
            ->log('Mengudate data layanan');

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, Request $request)
    {
        if ($service->serviceOrderDetails()->exists()) {
            return back()->with(
                'error',
                'Layanan tidak dapat dihapus karena sudah digunakan pada transaksi service.'
            );
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($service)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Service',
            ])
            ->log('Menghapus data layanan');

        $service->forceDelete(); // lebih baik daripada forceDelete()

        return back()->with(
            'success',
            'Layanan berhasil dihapus'
        );
    }
}
