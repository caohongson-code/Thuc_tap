<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['id_sanpham', 'id_KH', 'noi_dung'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_KH');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham');
    }
}

