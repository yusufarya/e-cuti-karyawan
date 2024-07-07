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
        Schema::create('emp_leaves', function (Blueprint $table) {
            $table->id();
            $table->char('emp_nik')->nullable(false);
            $table->foreign('emp_nik')->on('employees')->references('nik');
            $table->date('start_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('end_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('reason', 200)->nullable(true);
            $table->string('leave_type', 30)->nullable(false);
            $table->enum('approved1', ["Y", "N", 'X'])->default('X');
            $table->string('approved1_by', 200)->nullable(true);
            $table->enum('approved2', ["Y", "N", 'X'])->default('X');
            $table->string('approved2_by', 200)->nullable(true);
            $table->text('file')->nullable();
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
        Schema::dropIfExists('emp_leaves');
    }
};
