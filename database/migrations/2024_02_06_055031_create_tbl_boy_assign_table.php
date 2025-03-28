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
        Schema::create('tbl_boy_assign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tbl_our_team_id')->nullable();  
            $table->bigInteger('tbl_building_id')->nullable(); 
            $table->bigInteger('room_id')->nullable();
            $table->dateTime('assigned_date')->nullable(); 
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();
            $table->enum('assign_status', ['assigned', 'not_assigned'])->nullable();
            $table->text('remarks')->nullable(); 
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
        Schema::dropIfExists('tbl_boy_assign');
    }
};
