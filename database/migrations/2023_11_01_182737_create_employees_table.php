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
        Schema::create('employees', function (Blueprint $table) {
            $table->char('nik', 16)->primary();;
            $table->string('fullname', 100);
            $table->char('username', 30)->unique('users_username_unique');
            $table->enum('gender', ["M", "F"]);
            $table->string('place_of_birth', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('religion', 20)->nullable();
            $table->string('material_status', 30)->nullable();
            $table->text('image')->nullable();
            $table->string('email', 100)->unique('users_email_unique');
            $table->string('password');
            $table->enum('is_active', ["Y", "N"])->default('Y');
            $table->enum('deleted', ["Y", "N"])->default('N');
            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('created_by', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
