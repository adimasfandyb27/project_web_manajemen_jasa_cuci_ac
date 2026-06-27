<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $table = 'service_orders';

    protected $fillable = [
        'nomor_order',
        'customer_id',
        'technician_id',
        'tanggal_order',
        'jadwal_servis',
        'alamat_servis',
        'keluhan',
        'catatan',
        'status',
        'subtotal_jasa',
        'subtotal_sparepart',
        'diskon',
        'grand_total',
        'cancel_reason',
        'cancelled_at',
    ];

    public static function generateKode()
    {
        $tanggal = now()->format('Ymd');
        $prefix = 'SO'.$tanggal;

        $last = static::where('nomor_order', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->first();

        $urutan = 1;

        if ($last) {
            $urutan = ((int) substr($last->nomor_order, -4)) + 1;
        }

        return $prefix.str_pad(
            $urutan,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function details()
    {
        return $this->hasMany(ServiceOrderDetail::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
