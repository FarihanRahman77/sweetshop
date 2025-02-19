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
        Schema::create('tbl_accounts_coas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('amount',10,2)->default(0);
            $table->biginteger('code')->nullable();
            $table->biginteger('our_code')->nullable();
            $table->biginteger('limit_from')->nullable();
            $table->biginteger('limit_to')->nullable();
            $table->biginteger('parent_id')->nullable();
            $table->enum('unused',['Yes','No'])->default('No');

            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->enum('deleted',['Yes', 'No'])->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('last_updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_date')->format('d/m/Y')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_accounts_coas');
    }
};
