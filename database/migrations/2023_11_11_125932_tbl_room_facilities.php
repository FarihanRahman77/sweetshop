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
        Schema::create('tbl_room_facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value')->nullable();
            $table->string('remarks')->nullable();
            $table->bigInteger('tbl_facilities_id')->nullable();  
            $table->bigInteger('tbl_room_id')->nullable();
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
        Schema::dropIfExists('tbl_room_facilities');
    }
};
