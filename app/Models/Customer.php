<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'mobile',
    ];

    public function users()
    {
        return  $this->belongsTo(User::class);
    }

    public function orders(){

        return $this->hasMany(Order::class,'customer_id','user_id');
    }

 
}
