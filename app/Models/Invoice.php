<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'nomor_invoice',
        'service_order_id',
        'tanggal_invoice',
        'subtotal',
        'diskon',
        'total',
        'status',
        'bukti_bayar',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function generateNomor()
    {
        $tanggal = now()->format('Ymd');

        $lastInvoice = self::orderByDesc('id')->first();

        if ($lastInvoice) {
            $parts = explode('-', $lastInvoice->nomor_invoice);
            $nomor = ((int) end($parts)) + 1;
        } else {
            $nomor = 1;
        }

        return 'INV-NS-' . $tanggal . '-' .
            str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }
}
