<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {

            $data = Customer::select(['id', 'kode_customer', 'nama', 'telepon', 'email', 'alamat']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {

                    $editUrl = route('admin.customers.edit', $row->id);
                    $deleteUrl = route('admin.customers.destroy', $row->id);

                    return '
                    <div class="flex justify-center gap-2">
                        <a href="' . $editUrl . '"
                           class="px-3 py-2 text-xs rounded-xl bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100">
                            Edit
                        </a>

                        <form method="POST" action="' . $deleteUrl . '">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button onclick="return confirm(\'Hapus customer ini?\')"
                                class="px-3 py-2 text-xs rounded-xl bg-red-50 text-red-600 border border-red-200 hover:bg-red-100">
                                Hapus
                            </button>
                        </form>
                    </div>
                ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.customers.index', [
            'totalCustomer' => Customer::count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_customer = Customer::generateKode();
        return view('admin.customers.create', compact('kode_customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'telepon' => 'required|max:20',
        ]);

        $customer = Customer::create([
            'kode_customer' => Customer::generateKode(),
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($customer)
            ->withProperties([
                'ip' => $request->ip(),
                'module' => 'Customer',
            ])
            ->log('Menambahkan customer baru');

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan');
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
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customer $customer)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'telepon' => 'required|max:20',
        ]);

        $oldData = $customer->getOriginal();

        $customer->update($request->only([
            'nama',
            'telepon',
            'email',
            'alamat'
        ]));

        activity()
            ->causedBy(auth()->user())
            ->performedOn($customer)
            ->withProperties([
                'ip' => $request->ip(),
                'before' => $oldData,
                'after' => $customer->fresh(),
                'module' => 'Customer',
            ])
            ->log('Mengupdate data customer');

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->serviceOrders()->exists()) {
            return back()->with(
                'error',
                'Customer tidak dapat dihapus karena sudah digunakan pada transaksi service.'
            );
        }

        $deletedData = $customer->toArray();

        $customer->forceDelete();

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'deleted_data' => $deletedData,
                'module' => 'Customer',
            ])
            ->log('Menghapus customer');

        return back()->with(
            'success',
            'Customer berhasil dihapus'
        );
    }
}
