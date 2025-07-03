<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Để sử dụng chức năng login
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Cho phép gán các trường này
protected $fillable = [
    'ten',
    'ho',
    'email',
    'matkhau',
    'dien_thoai',
    'dia_chi',
    'thanhpho',
    'vai_tro',
];



    // Ẩn các trường này khi trả JSON hoặc serialize
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tự động ép kiểu
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'id_KH');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_KH');
    }
}
