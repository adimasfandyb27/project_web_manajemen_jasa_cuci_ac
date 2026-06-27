<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function edit()
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        return view('customer.profile.edit', compact('customer'));
    }

    /**
     * Update profil customer
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $customer = Customer::where('user_id', auth()->id())->first();

        if (! $customer) {
            return back()->with('error', 'Data customer tidak ditemukan.');
        }

        // Upload foto baru
        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($customer->photo && Storage::disk('public')->exists($customer->photo)) {
                Storage::disk('public')->delete($customer->photo);
            }

            $customer->photo = $request->file('photo')
                ->store('customers', 'public');
        }

        $customer->nama = $request->nama;
        $customer->telepon = $request->telepon;
        $customer->alamat = $request->alamat;

        $customer->save();

        // sinkronkan nama di tabel users
        if (auth()->user()) {
            auth()->user()->update([
                'name' => $request->nama,
            ]);
        }

        return redirect()
            ->route('customer.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
