<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'name',
        'link',
        'image',
        'new_window',
        'slug',
        'status',
       
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);

    }

}
