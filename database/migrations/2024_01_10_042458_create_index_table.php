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
        Schema::create('index', function (Blueprint $table) {
            $table->id();
            $table->string('term')->nullable();
            $table->unsignedBigInteger('berita_id')->nullable();
            $table->integer('jumlah')->nullable();
            $table->float('bobot')->nullable();
            $table->timestamps();

            $table->foreign('berita_id')->references('id')->on('berita')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index');
    }
};
