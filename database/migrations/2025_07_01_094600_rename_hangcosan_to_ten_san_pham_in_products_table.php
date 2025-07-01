<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('hangcosan', 'ten_san_pham');
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('ten_san_pham', 'hangcosan');
        });
    }
};
