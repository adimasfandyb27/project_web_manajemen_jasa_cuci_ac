<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class customer_ac_units extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_ac_units';

    protected $fillable = [
        'customer_id',
        'ac_brand_id',
        'ac_type_id',
        'ac_capacity_id',
        'model',
        'serial_number',
        'lokasi',
        'catatan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function brand()
    {
        return $this->belongsTo(ac_brands::class, 'ac_brand_id');
    }

    public function type()
    {
        return $this->belongsTo(ac_types::class, 'ac_type_id');
    }

    public function capacity()
    {
        return $this->belongsTo(ac_capacities::class, 'ac_capacity_id');
    }
}
