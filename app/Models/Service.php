<?php

namespace App\Models;

use App\Models\ServiceOrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';
    protected $fillable = [
        'kode_layanan',
        'nama_layanan',
        'harga',
        'deskripsi'
    ];

    public static function generateKode()
    {
        $last = static::withTrashed()
            ->orderByDesc('id')
            ->first();

        $urutan = $last
            ? ((int) substr($last->kode_layanan, 3)) + 1
            : 1;

        return 'SRV' . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }
    public function serviceOrderDetails()
    {
        return $this->hasMany(
            ServiceOrderDetail::class,
            'service_id',
            'id'
        );
    }
}
