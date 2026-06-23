<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'service_order_details';

    protected $fillable = [
        'service_order_id',
        'service_id',
        'harga',
        'qty',
        'subtotal',
        'keterangan',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
