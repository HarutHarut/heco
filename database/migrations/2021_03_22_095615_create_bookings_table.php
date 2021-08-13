<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('set null');
            $table->foreignId('bike_id')->constrained('bikes')->onDelete('set null');
            $table->integer('price')->nullable();
            $table->string('status')->default('new');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('zip')->nullable();
            $table->string('token')->nullable();
            $table->string('payment_id')->nullable();
            $table->double('shipping')->nullable();
            $table->double('packaging')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
