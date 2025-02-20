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
        Schema::create('logistics', function (Blueprint $table) {
            $table->id('logistics_id');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->enum('housekeeping_status', ['cleaned', 'dirty', 'under maintenance']);
            $table->enum('maintenance_status', ['scheduled', 'completed', 'not required']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Logistics');
    }
};
