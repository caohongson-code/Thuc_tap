<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
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
