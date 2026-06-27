<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technician extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'technicians';

    protected $fillable = [
        'kode_teknisi',
        'nama',
        'telepon',
        'alamat',
        'status',
    ];

    public static function generateKode()
    {
        $last = static::withTrashed()
            ->orderByDesc('id')
            ->first();

        $urutan = $last
            ? ((int) substr($last->kode_teknisi, 3)) + 1
            : 1;

        return 'TKN'.str_pad($urutan, 6, '0', STR_PAD_LEFT);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class, 'technician_id');
    }
}
