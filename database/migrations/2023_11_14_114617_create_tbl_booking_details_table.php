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
        Schema::create('tbl_booking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tbl_booking_id')->nullable();  
            $table->bigInteger('tbl_room_id')->nullable();  
            $table->dateTime('booking_from')->nullable();  
            $table->dateTime('booking_to')->nullable();
            $table->integer('tariff_fee')->nullable();
            $table->integer('adult')->nullable();
            $table->integer('child')->nullable();
            $table->decimal('price', 10, 2)->default('0.00');
            $table->string('payable_tariff')->nullable();
            $table->dateTime('checkin_date')->nullable();
            $table->dateTime('checkout_date')->nullable();
            $table->dateTime('cancellation_date')->nullable();	
            $table->enum('states', ['check_in', 'accupied', 'check_out', 'release'])->default("release");
            $table->enum('deleted',['Yes', 'No'])->default("No");
            $table->enum('status', ['Active', 'Inactive'])->default("Active");
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_date')->nullable();
            $table->timestamps();
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_booking_details');
    }
};
