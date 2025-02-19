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
        Schema::create('tbl_inventory_damage_products', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('damage_order_no')->nullable();
            $table->biginteger('products_id')->nullable();
            $table->biginteger('warehouse_id')->nullable();
            $table->biginteger('damage_quantity')->nullable();
            $table->date('damage_date')->nullable();
            $table->longtext('remarks')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->enum('deleted',['Yes','No'])->default('No');
            $table->biginteger('created_by')->nullable();
            $table->biginteger('updated_by')->nullable();
            $table->biginteger('deleted_by')->nullable();
            $table->date('deleted_date')->nullable();
            $table->datetime('created_date')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_inventory_damage_products');
    }
};
