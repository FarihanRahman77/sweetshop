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
        Schema::create('tbl_booking', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->dateTime('booking_date')->nullable();
            $table->dateTime('approximate_arrival')->nullable();
            $table->dateTime('approximate_checkout')->nullable();
            $table->enum('booking_status',['pre_booked', 'booked'])->default("booked"); 
            $table->bigInteger('tbl_building_Id')->nullable();  
            $table->bigInteger('tbl_party_id')->nullable();  
            $table->integer('adult_member')->nullable();  
            $table->integer('child_member')->nullable();  
            $table->string('referal')->nullable();
            $table->string('complementary_breakfast')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('totalPrice', 10, 2)->default('0.00');  
            $table->decimal('grand_total', 10, 2)->default('0.00');  
            $table->string('payable_tarrif')->nullable();
            $table->double('discount',10,2)->nullable();
            $table->double('total_discount',10,2)->nullable();
            $table->double('down_payment',10,2)->nullable();
            $table->double('payable_amount',10,2)->nullable();
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
        Schema::dropIfExists('tbl_booking');
    }
};
