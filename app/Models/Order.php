<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        
        'id_KH',
        'ten',
        'email',
        'dien_thoai',
        'tong_mathang',
        'tong_gia',
        'dia_chi',
        'vanchuyen_thanhpho',
        'trangthai',
    ];

public function items()
{
    return $this->hasMany(\App\Models\OrderItem::class, 'id_dathang');
}

}


