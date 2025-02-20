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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('guestName');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'cash', 'online']);
            $table->unsignedBigInteger('total_amount');
            $table->enum('status', ['checkIn', 'checkOut']);
            $table->string('nota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Bookings');
    }
};
