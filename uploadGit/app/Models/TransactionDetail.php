<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Tambahkan relasi ini agar terhubung ke data produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}