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
        Schema::create('tbl_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id')->nullable();  
            $table->bigInteger('sheet_id')->nullable(); 
            $table->string('member_name')->nullable();
            $table->string('member_desingnation')->nullable();
            $table->bigInteger('priority')->nullable(); 
            $table->bigInteger('mobile_number')->nullable();
            $table->bigInteger('working_hour')->nullable();
            $table->bigInteger('current_grade')->nullable();
            $table->bigInteger('current_step')->nullable();
            $table->bigInteger('account_no')->nullable();
            $table->decimal('amount', 10, 2)->decimal('0.00');
            $table->decimal('salary', 10, 2)->decimal('0.00');
            $table->decimal('laundry', 10, 2)->decimal('0.00');
            $table->decimal('phone_bill', 10, 2)->decimal('0.00');
            $table->decimal('ta_da')->decimal('0.00');
            $table->longtext('address')->nullable();
            $table->string('member_image')->nullable();
            $table->string('job_location')->nullable();
            $table->string('salary_type')->nullable();
            $table->string('is_employee')->nullable();
            $table->string('member_education')->nullable();
            $table->longtext('description')->nullable();
            $table->text('social_links')->nullable();
            $table->longtext('short_note')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('job_left_date')->nullable();
            $table->string('referred_by')->nullable();
            $table->enum('deleted',['Yes', 'No'])->default("No");
            $table->enum('status', ['Active', 'Inactive'])->default("Active");
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
        Schema::dropIfExists('tbl_employee');
    }
};
