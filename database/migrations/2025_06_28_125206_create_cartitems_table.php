<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_giohang')->constrained('carts');
            $table->foreignId('id_sanpham')->constrained('products');
            $table->foreignId('id_bien')->constrained('productvariants');
            $table->decimal('gia', 10, 2);
            $table->decimal('tong_gia', 10, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
