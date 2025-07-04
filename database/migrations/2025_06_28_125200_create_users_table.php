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
      Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('ten');
        $table->string('ho');
        $table->string('email')->unique();
        $table->string('matkhau');
        $table->string('dien_thoai');
        $table->string('dia_chi');
        $table->string('thanhpho');
        $table->string('role')->default('user');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
