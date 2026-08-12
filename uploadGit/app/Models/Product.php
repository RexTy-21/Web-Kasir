<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Supaya aman saat insert data
    protected $guarded = ['id'];

    // Mendefinisikan relasi: Banyak produk dimiliki oleh 1 kategori (BelongsTo)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}