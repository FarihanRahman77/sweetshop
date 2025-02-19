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
        Schema::create('tbl_inventory_product_specification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('tbl_product_id');
            $table->string('specification_name')->nullable();
            $table->string('specification_value')->nullable();
            // Common Fields
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->enum('deleted',['Yes','No'])->default('No');
            $table->biginteger('created_by')->nullable();
            $table->datetime('created_date')->nullable();
            $table->biginteger('updated_by')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->biginteger('deleted_by')->nullable();
            $table->datetime('deleted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_inventory_product_specification');
    }
};
