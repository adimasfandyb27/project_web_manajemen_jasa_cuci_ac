<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ac_brands extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ac_brands';

    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];

    public static function generateKode()
    {
        $last = static::withTrashed()
            ->orderByDesc('id')
            ->first();

        $urutan = $last
            ? ((int) substr($last->kode, 3)) + 1
            : 1;

        return 'BRN'.str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }
}
