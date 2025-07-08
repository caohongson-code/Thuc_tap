<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'phuongthuc_thanhtoan', 'trangthai_thanhtoan', 'sotien_thanhtoan', 'ngay_thanh_toan'
    ];
}