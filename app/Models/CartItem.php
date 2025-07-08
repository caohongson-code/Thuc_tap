<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CartItem extends Model
{
    protected $table = 'cartitems';

    protected $fillable = ['id_giohang', 'id_sanpham', 'id_bien', 'gia', 'so_luong', 'tong_gia'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_bien');
    }

    public function cart()
{
    return $this->belongsTo(Cart::class, 'id_giohang');
}

}


