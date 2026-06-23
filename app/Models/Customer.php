<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'kode_customer',
        'nama',
        'telepon',
        'email',
        'alamat',
        'photo',
    ];

    public static function generateKode()
    {
        $lastCustomer = self::withTrashed()
            ->latest('id')
            ->first();

        $nextNumber = $lastCustomer
            ? ((int) substr($lastCustomer->kode_customer, 3)) + 1
            : 1;

        return 'CUS' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
