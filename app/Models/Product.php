<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_san_pham',
        'mota',
        'gia_coso',
        'id_danhmuc',
        'trang_thai',
        'ma_hang',
        'hinhanh',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_danhmuc');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'id_sanpham');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'id_sanpham');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_sanpham');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_sanpham');
    }
    public function comments()
{
    return $this->hasMany(Comment::class, 'id_sanpham');
}


    
}
