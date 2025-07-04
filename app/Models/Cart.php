<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = ['id_KH', 'id_sanpham', 'tong_mathang', 'tong_gia'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_giohang');
    }
}


