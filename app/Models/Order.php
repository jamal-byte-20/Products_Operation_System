<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function calculateTotalPrice()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price * $product->quantity;
        }
        return $total;
    }
}
