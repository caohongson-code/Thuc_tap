<?php

namespace App\Models;

use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'productvariants';
    protected $fillable = [
        'id_sanpham',
        'kich_co',
        'gia',
        'tonkho',
    ];
    //

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_bienthe');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_bien');
    }
    // App\Models\ProductVariant.php
public function product()
{
    return $this->belongsTo(Product::class, 'id_sanpham');
}

}
