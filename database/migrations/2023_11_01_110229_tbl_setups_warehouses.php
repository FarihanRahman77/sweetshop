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
        Schema::create('tbl_setups_warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();  
            $table->integer('no_of_beds')->nullable();
            $table->integer('no_of_rooms')->nullable();
            $table->integer('no_of_washroom')->nullable();
            $table->integer('no_of_belcony')->nullable();
            $table->integer('bath_tubs')->nullable();
            $table->string('room_size')->nullable();  
            $table->string('room_capacity_adult')->nullable();  
            $table->string('room_capacity_child')->nullable();  
            $table->string('spectacular_view')->nullable();  
            $table->double('price',10,2)->nullable();  
            $table->double('corporate_price',10,2)->nullable();  
            $table->float('multiple_images')->nullable();  
            $table->bigInteger('tbl_building_id')->nullable();
            $table->bigInteger('tbl_floor_id')->nullable();
            $table->bigInteger('tbl_sister_concern_id')->nullable();
            $table->bigInteger('tbl_category_id')->nullable();
            $table->string('description')->nullable();
            $table->enum('type',['room', 'warehouse'])->nullable();
            $table->enum('deleted',['Yes', 'No'])->default("No");
            $table->enum('status', ['Active', 'Inactive'])->default("Active");
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('updated_date')->nullable();
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
        Schema::dropIfExists('tbl_setups_warehouses');
    }
};
