<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Mendefinisikan relasi: 1 kategori memiliki banyak produk (HasMany)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
