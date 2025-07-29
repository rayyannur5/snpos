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
        Schema::create('smart_nitro_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('smart_nitro_id');
            $table->integer('product_id');
            $table->integer('type_data');
            $table->integer('data_1');
            $table->integer('data_2');
            $table->integer('data_3');
            $table->integer('data_4');
            $table->integer('data_5');
            $table->integer('data_6');
            $table->integer('data_7');
            $table->integer('data_8');
            $table->integer('data_9');
            $table->integer('data_10');
            $table->integer('data_11');
            $table->integer('data_12');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_nitro_transactions');
    }
};
