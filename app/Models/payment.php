<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_type',
        'payment_method',
        'paid_at',
        'notes',
        'proof_file',
        'status',
    ];

    public function invoice()
    {
        return $this->belongsTo(invoice::class);
    }

}
