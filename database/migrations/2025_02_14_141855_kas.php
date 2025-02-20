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
        Schema::create('Kas', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('transaction')->nullable();
            $table->integer('saldo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Kas');
    }
};
