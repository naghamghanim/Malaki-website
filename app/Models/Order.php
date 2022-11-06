<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'order_status_id',
        'total_price',
        'total_items',
        'name',
        'email',
        'phone',
        'mobile',
        'country_id',
        'city',
        'address'
    ];
    protected $appends = [
        'status'
    ];
    public function getStatusAttribute(){
        return OrderStatus::find($this->order_status_id);
    }
    public function orderStatus(){
        return $this->belongsTo(OrderStatus::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderDetails::class,'order_id','id');
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
  
   
}



