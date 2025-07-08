<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 👇 Xoá khóa ngoại trước (đúng tên)
            $table->dropForeign('orders_id_giohang_foreign');

            // 👇 Rồi mới xoá cột
            $table->dropColumn('id_giohang');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id_giohang')->nullable();

            // Thêm lại foreign key nếu rollback
            $table->foreign('id_giohang')->references('id')->on('carts')->onDelete('cascade');
        });
    }
};
