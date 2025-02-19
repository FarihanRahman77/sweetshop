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
        Schema::create('tbl_inventory_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('image')->nullable();
            $table->string('barcode_no')->nullable();
            $table->string('model_no')->nullable();

            $table->biginteger('category_id')->nullable();
            $table->biginteger('brand_id')->nullable();
            $table->biginteger('unit_id')->nullable();
            $table->biginteger('opening_stock')->nullable();
            $table->biginteger('remainder_quantity')->default(0);
            $table->biginteger('purchase_quantity')->nullable();
            $table->biginteger('current_stock')->nullable();
            $table->biginteger('sale_quantity')->nullable();
            $table->biginteger('items_in_box')->nullable();

            $table->decimal('purchase_price',12,2)->nullable();
            $table->decimal('sale_price',12,2)->nullable();
            $table->decimal('discount',12,2)->nullable();
            $table->decimal('total_purchase_price',12,2)->nullable();
            $table->decimal('total_sale_price',12,2)->nullable();
            $table->decimal('remaining_price',12,2)->nullable();

            $table->longtext('notes')->nullable();

            $table->enum('type',['regular','serialize','service'])->nullable();
            $table->enum('stock_check',['Yes','No'])->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->enum('deleted',['Yes','No'])->default('No');
            
            $table->biginteger('created_by')->nullable();
            $table->biginteger('updated_by')->nullable();
            $table->biginteger('deleted_by')->nullable();
            $table->datetime('deleted_date')->nullable();
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
        Schema::dropIfExists('tbl_inventory_products');
    }
};
