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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->biginteger('usertype_id')->nullable();
            $table->string('image')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('address')->nullable();
            $table->biginteger('sister_concern_id')->nullable();
            $table->string('role')->nullable();
            $table->enum('status',['Active','Inactive']);
            $table->enum('deleted',['Yes','No']);

            $table->biginteger('created_by')->nullable();
            $table->datetime('created_date')->nullable();
            $table->biginteger('updated_by')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->biginteger('deleted_by')->nullable();
            $table->datetime('deleted_date')->nullable();

            $table->biginteger('current_team_id')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('signature')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
