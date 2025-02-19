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
        Schema::create('tbl_room_floor_and_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('sister_concern_id')->nullable();
            $table->biginteger('warehouse_id')->nullable();
            $table->biginteger('floor_id')->nullable();
            $table->biginteger('room_id')->nullable();
            
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('created_date')->format('d/m/Y')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('updated_date')->format('d/m/Y')->nullable();
            $table->enum('deleted',['Yes', 'No'])->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_date')->format('d/m/Y')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_room_floor_and_warehouses');
    }
};
