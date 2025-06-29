<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $table="categories";
    public $timestamps=false;// không có trường created_at và updated_at 
    
    protected $fillable=[
        'ten',
        'mieu_ta',
        'trang_thai',
    ];

    //
}
