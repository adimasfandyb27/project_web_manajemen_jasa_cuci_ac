<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ac_brands;
use App\Models\ac_capacities;
use App\Models\ac_types;
use App\Models\Customer;
use App\Models\customer_ac_units;
use Illuminate\Http\Request;

class CustomerAcUnitController extends Controller
{
    protected function getCustomer()
    {
        return Customer::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $customer = $this->getCustomer();
        $units = customer_ac_units::where('customer_id', $customer->id)
            ->with(['brand', 'type', 'capacity'])
            ->latest()
            ->get();

        return view('customer.ac-units.index', compact('customer', 'units'));
    }

    public function create()
    {
        $customer = $this->getCustomer();
        $brands = ac_brands::all();
        $types = ac_types::all();
        $capacities = ac_capacities::all();

        return view('customer.ac-units.create', compact('customer', 'brands', 'types', 'capacities'));
    }

    public function store(Request $request)
    {
        $customer = $this->getCustomer();

        $request->validate([
            'ac_brand_id' => 'required|exists:ac_brands,id',
            'ac_type_id' => 'required|exists:ac_types,id',
            'ac_capacity_id' => 'required|exists:ac_capacities,id',
            'model' => 'nullable|max:255',
            'serial_number' => 'nullable|max:255',
            'lokasi' => 'nullable|max:255',
            'catatan' => 'nullable|max:1000',
        ]);

        customer_ac_units::create([
            'customer_id' => $customer->id,
            'ac_brand_id' => $request->ac_brand_id,
            'ac_type_id' => $request->ac_type_id,
            'ac_capacity_id' => $request->ac_capacity_id,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('customer.ac-units.index')
            ->with('success', 'Unit AC berhasil ditambahkan');
    }

    public function edit($id)
    {
        $customer = $this->getCustomer();
        $unit = customer_ac_units::where('customer_id', $customer->id)->findOrFail($id);
        $brands = ac_brands::all();
        $types = ac_types::all();
        $capacities = ac_capacities::all();

        return view('customer.ac-units.edit', compact('customer', 'unit', 'brands', 'types', 'capacities'));
    }

    public function update(Request $request, $id)
    {
        $customer = $this->getCustomer();
        $unit = customer_ac_units::where('customer_id', $customer->id)->findOrFail($id);

        $request->validate([
            'ac_brand_id' => 'required|exists:ac_brands,id',
            'ac_type_id' => 'required|exists:ac_types,id',
            'ac_capacity_id' => 'required|exists:ac_capacities,id',
            'model' => 'nullable|max:255',
            'serial_number' => 'nullable|max:255',
            'lokasi' => 'nullable|max:255',
            'catatan' => 'nullable|max:1000',
        ]);

        $unit->update($request->only([
            'ac_brand_id',
            'ac_type_id',
            'ac_capacity_id',
            'model',
            'serial_number',
            'lokasi',
            'catatan',
        ]));

        return redirect()
            ->route('customer.ac-units.index')
            ->with('success', 'Unit AC berhasil diperbarui');
    }

    public function destroy($id)
    {
        $customer = $this->getCustomer();
        $unit = customer_ac_units::where('customer_id', $customer->id)->findOrFail($id);

        $unit->delete();

        return redirect()
            ->route('customer.ac-units.index')
            ->with('success', 'Unit AC berhasil dihapus');
    }
}
