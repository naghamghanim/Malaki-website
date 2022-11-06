<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'total_price',
    ];
    protected $appends = [
        'product'
    ];
    public function getProductAttribute(){
        $product = Product::find($this->product_id);
        return [
            'id'  => $product->id,
            'name'=>$product->name,
            'img'=>$product->img,
           
        ];
    }
    
    
        protected $table = 'order_details';

    public function product(){
        return $this->belongsTo(Product::class);
    }

   
}
