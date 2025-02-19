<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tbl_inventory_sale_orders', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->biginteger('customer_id')->nullable();
            $table->string('sale_no')->nullable();
            $table->string('date', 20)->nullable();
            $table->string('project_name')->nullable();
            $table->longtext('description')->nullable(); 
            $table->string('purchase_from')->nullable(); 
            $table->string('manufature_no')->nullable(); 
            $table->string('category')->nullable(); 
            $table->longtext('service_note')->nullable(); 

            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('carrying_cost', 12, 2)->default(0.00);
            $table->decimal('vat',10,2)->default(0.00);
            $table->decimal('ait',10,2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            $table->decimal('advance_payment', 12, 2)->default(0.00);
            $table->decimal('previous_due', 12, 2)->default(0.00);
            $table->decimal('total_with_due', 12, 2)->default(0.00);
            $table->decimal('current_payment', 12, 2)->default(0.00);
            $table->decimal('final_sale_amount', 12, 2)->default(0.00);
            $table->decimal('current_balance', 12, 2)->default(0.00);
            
            $table->decimal('total_price', 12, 2)->default(0.00);
            $table->decimal('dues_amount', 12, 2)->default(0.00);
            $table->decimal('current_dues', 12, 2)->default(0.00);
            $table->date('start_date')->nullable();

            $table->enum('sales_type',['walkin_sale','FS','party_sale']);
            // New Fields
            $table->string('work_approval_date', 20)->nullable();
            $table->string('expected_delivery_date', 20)->nullable();
            $table->string('manufacturing_si_no')->nullable();
            $table->string('accessories_recieved')->nullable();
            $table->string('other_accessories')->nullable();

            $table->biginteger('quantity')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('item')->nullable();

            $table->date('service_start_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->date('ready_to_deliver_date')->nullable();
            $table->date('customer_change_date')->nullable();

            // Common Fields
            $table->enum('order_status', ['Pending','Completed','Servicing','Cancelled','Delivered','Decline','ReadyToDeliverd'])->default('Pending');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('sale_status',['Incomplete','Completed'])->default('Incomplete');
            $table->enum('deleted', ['Yes', 'No'])->default('No');
            $table->biginteger('created_by')->nullable();
            $table->datetime('created_date')->nullable();
            $table->biginteger('updated_by')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->biginteger('deleted_by')->nullable();
            $table->datetime('deleted_date')->nullable();
            $table->timestamps();
            // End Common Fields
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
