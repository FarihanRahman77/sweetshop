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
        Schema::create('tbl_building', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();  
            $table->string('color')->nullable();  
            $table->integer('no_of_floor')->nullable();  
            $table->string('address')->nullable();  
            $table->text('remarks')->nullable();  
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->enum('deleted',['Yes', 'No'])->nullable();
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
        Schema::dropIfExists('tbl_building');
    }
};
