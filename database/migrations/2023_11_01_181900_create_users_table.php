<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('nip', 20)->primary();
            $table->string('fullname', 100);
            $table->char('username', 30)->unique('users_username_unique');
            $table->enum('gender', ["M", "F"]);
            $table->string('place_of_birth', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('email', 100)->unique('users_email_unique');
            $table->string('password');
            $table->unsignedBigInteger('level_id');
            $table->enum('is_active', ["Y", "N"])->default('N');
            $table->text('images')->nullable();
            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('created_by', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 50)->nullable();
            
            $table->foreign('level_id')->on('user_levels')->references('id');
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
