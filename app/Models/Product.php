<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'product_category_id',
        'details',
        'regular_price',
        'discount',
        'quantity',
        'status',
        'img'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);

    }

}
