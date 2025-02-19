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
        Schema::create('tbl_settings_company_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->nullable();
            $table->string('vertical_logo')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->text('report_header')->nullable();
            $table->text('report_footer')->nullable();
            $table->string('watermark')->nullable();
            $table->string('month_year')->nullable();
            $table->string('terms_conditions')->nullable();
            $table->string('default_party')->nullable();
            $table->string('currency')->nullable();
            $table->enum('is_admin',['Yes','No'])->nullable();
            $table->enum('is_hotel',['Yes','No'])->default('No');
            $table->enum('is_restaurent',['Yes','No'])->default('No');
            $table->enum('is_shop',['Yes','No'])->default('No');
            $table->enum('is_office',['Yes','No'])->default('No');
            $table->enum('manage_stock_to_sale',['Yes','No'])->default('Yes');
            $table->enum('barcode_exists',['Yes','No'])->nullable();

            $table->enum('deleted',['Yes','No'])->nullable();
            $table->enum('status',['Active','Inactive'])->nullable();
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
        Schema::dropIfExists('tbl_settings_company_settings');
    }
};
