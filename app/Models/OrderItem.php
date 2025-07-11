<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/OrderItem.php
class OrderItem extends Model
{
    protected $table = 'orderitems';
    protected $fillable = [
        'id_dathang', 'id_sanpham', 'id_bienthe', 'soluong', 'gia', 'tong_gia'
    ];
    public function product()
{
    return $this->belongsTo(\App\Models\Product::class, 'id_sanpham');
}

public function variant()
{
    return $this->belongsTo(\App\Models\ProductVariant::class, 'id_bienthe');
}
public function order()
{
    return $this->belongsTo(Order::class, 'id_dathang');
}


}

// app/Models/Payment.php


