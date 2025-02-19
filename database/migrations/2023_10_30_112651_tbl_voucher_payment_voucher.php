<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tbl_voucher_payment_vouchers', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->biginteger('party_id')->nullable();
            $table->biginteger('purchase_id')->nullable();
            $table->biginteger('order_sale_id')->nullable();
            $table->bigInteger('tbl_booking_id')->nullable();  
            $table->decimal('amount',10,2)->default(0.00);
            $table->biginteger('entryBy')->nullable();
            $table->decimal('discount',10,2)->default(0.00);
            $table->string('payment_method')->nullable();
            $table->string('chequeNo')->nullable();
            $table->date('paymentDate')->nullable();
            $table->date('chequeIssueDate')->nullable();
            $table->string('accountNo')->nullable();
            $table->enum('type',['Payment Received', 'Payment', 'Payable', 'Party Payable', 'Payment Adjustment', 'Adjustment', 'Discount']);
            $table->longtext('remarks')->nullable();
            $table->biginteger('bill_id')->nullable();
            $table->biginteger('tbl_bankInfoId')->nullable();
            $table->biginteger('lastUpdatedBy')->nullable();
            $table->enum('voucherType',['Local Purchase','Foreign Purchase', 'WalkinSale', 'PartySale', 'FS','TS', 'PurchaseReturn', 'SalesReturn','Expense','Bill','Asset Purchase','Asset Sale']);
            $table->biginteger('sales_id')->nullable();
            $table->biginteger('purchase_return_id')->nullable();
            $table->biginteger('tbl_asset_purchase_id')->nullable();
            $table->biginteger('tbl_asset_sale_id')->nullable();
            $table->biginteger('sales_return_id')->nullable();
            $table->biginteger('expense_id')->nullable();
            $table->biginteger('tbl_repairing_center_id')->nullable();
            $table->enum('customerType',['WalkingCustomer', 'Party'])->default('Party');
            $table->string('voucherNo');
            $table->string('chequeBank')->nullable();
            $table->datetime('dbInsertDate')->nullable();
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
            // End Common Fields

        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('tbl_voucher_payment_vouchers');
    }
};
