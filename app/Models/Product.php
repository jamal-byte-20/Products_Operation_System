<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function categorys(){
        return $this->belongsToMany(Category::class);
    }
}
