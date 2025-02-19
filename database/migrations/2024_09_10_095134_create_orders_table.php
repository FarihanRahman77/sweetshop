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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('table_id')->nullable();
            $table->string('code')->nullable();
            $table->string('order_token')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('room_id')->nullable();  
            $table->bigInteger('warehouse_id')->nullable();  
            $table->bigInteger('sister_concern_id')->nullable();  
            $table->bigInteger('waiter_id')->nullable();  

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
        Schema::dropIfExists('orders');
    }
};
