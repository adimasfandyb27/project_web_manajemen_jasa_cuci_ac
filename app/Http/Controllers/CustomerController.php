<?php

namespace App\Http\Controllers;

use App\Models\ac_brands;
use App\Models\ac_capacities;
use App\Models\ac_types;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
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
                        <a href="'.$editUrl.'"
                           class="px-3 py-2 text-xs rounded-xl bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100">
                            Edit
                        </a>
                        <form method="POST" action="'.$deleteUrl.'">
                            '.csrf_field().'
                            '.method_field('DELETE').'
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

    public function create()
    {
        $kode_customer = Customer::generateKode();
        $brands = ac_brands::all();
        $types = ac_types::all();
        $capacities = ac_capacities::all();

        return view('admin.customers.create', compact(
            'kode_customer',
            'brands',
            'types',
            'capacities'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'telepon' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Customer');

        $customer = Customer::create([
            'user_id' => $user->id,
            'kode_customer' => Customer::generateKode(),
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        if ($request->filled('ac_units')) {
            foreach ($request->ac_units as $unit) {
                if (! empty($unit['ac_brand_id'])) {
                    $customer->acUnits()->create($unit);
                }
            }
        }

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

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $customer = Customer::with('acUnits')->findOrFail($id);
        $brands = ac_brands::all();
        $types = ac_types::all();
        $capacities = ac_capacities::all();

        $existingUnits = $customer->acUnits->map(function ($u) {
            return [
                'ac_brand_id' => $u->ac_brand_id,
                'ac_type_id' => $u->ac_type_id,
                'ac_capacity_id' => $u->ac_capacity_id,
                'model' => $u->model,
                'serial_number' => $u->serial_number,
                'lokasi' => $u->lokasi,
                'catatan' => $u->catatan,
            ];
        });

        return view('admin.customers.edit', compact(
            'customer',
            'brands',
            'types',
            'capacities',
            'existingUnits'
        ));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'telepon' => 'required|max:20',
            'email' => 'required|email'.($customer->user_id ? '|unique:users,email,'.$customer->user_id : '|unique:users,email'),
        ]);

        $oldData = $customer->getOriginal();

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
        }

        if ($customer->user) {
            $customer->user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $customer->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
        } elseif ($request->filled('password')) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('Customer');

            $customer->update(['user_id' => $user->id]);
        }

        $customer->update($request->only([
            'nama',
            'telepon',
            'email',
            'alamat',
        ]));

        if ($request->filled('ac_units')) {
            $customer->acUnits()->delete();

            foreach ($request->ac_units as $unit) {
                if (! empty($unit['ac_brand_id'])) {
                    $customer->acUnits()->create($unit);
                }
            }
        } else {
            $customer->acUnits()->delete();
        }

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

    public function destroy(Customer $customer)
    {
        if ($customer->serviceOrders()->exists()) {
            return back()->with(
                'error',
                'Customer tidak dapat dihapus karena sudah digunakan pada transaksi service.'
            );
        }

        $deletedData = $customer->toArray();

        $customer->acUnits()->delete();
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
