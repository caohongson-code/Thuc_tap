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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_danhmuc')->constrained('categories');
            $table->string('hangcosan');
            $table->text('mota')->nullable();
            $table->string('ma_hang')->unique();
            $table->decimal('gia_coso', 10, 2);
            $table->string('trang_thai')->default('active');
            $table->string('hinhanh')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
