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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_giohang')->constrained('carts');
            $table->foreignId('id_KH')->constrained('users');
            $table->string('ten');
            $table->string('email');
            $table->string('dien_thoai');
            $table->integer('tong_mathang');
            $table->decimal('tong_gia', 10, 2);
            $table->string('dia_chi');
            $table->string('vanchuyen_thanhpho');
            $table->string('trangthai')->default('choxuly');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
