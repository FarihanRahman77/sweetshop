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
        Schema::create('tbl_crm_parties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('country_name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact')->nullable();
            $table->string('alternate_contact')->nullable();
            $table->string('party_variety')->nullable();
            $table->string('customer_type')->nullable();
            $table->decimal('credit_limit',12,2)->nullable();
            $table->decimal('current_due',12,2)->nullable();
            $table->decimal('opening_due',12,2)->nullable();
            $table->enum('party_type',['Supplier','Customer','Walkin_Customer','Both','Investor']);
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->enum('deleted',['Yes','No'])->default('Yes');
            $table->biginteger('created_by')->nullable();
            $table->biginteger('last_updated_by')->nullable();
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
        Schema::dropIfExists('tbl_crm_parties');
    }
};
