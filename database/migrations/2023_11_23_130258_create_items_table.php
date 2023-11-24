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
        Schema::create('items', function (Blueprint $table) {
            /*Asumsikan id adalah kumpulan angka berjumlah 16*/
            $table->char("id", 16)->primary();
            $table->string('nama');
            /*Harga >= 0*/
            $table->double('harga', 10, 2);
            /*Stok >= 0*/
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
