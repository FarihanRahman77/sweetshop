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
        Schema::create('tbl_acc_voucher_details', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('tbl_acc_coa_id')->nullable();
            $table->biginteger('tbl_acc_voucher_id')->nullable();
            $table->bigInteger('tbl_booking_id')->nullable();  
            $table->biginteger('purchase_id')->nullable();
            $table->biginteger('sales_id')->nullable();
            $table->longtext('particulars')->nullable();
            $table->decimal('debit',10,2)->nullable();
            $table->decimal('credit',10,2)->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('voucher_title')->nullable();
            $table->biginteger('tbl_booking_id')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->enum('deleted',['Yes', 'No'])->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->bigInteger('last_updated_by')->nullable();
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
        //
    }
};
