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
        Schema::create('tbl_facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facility_name')->nullable();
            $table->string('facility_value')->nullable();  
            $table->string('serial')->nullable();  
            $table->string('icons')->nullable();  
            $table->string('facility_head')->nullable();  
            $table->bigInteger('tbl_category_id')->nullable();
            $table->bigInteger('tbl_sisterconcern_id')->nullable();
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
        Schema::dropIfExists('tbl_facilities');
    }
};
