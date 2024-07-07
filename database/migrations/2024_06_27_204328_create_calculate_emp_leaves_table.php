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
        Schema::create('calculate_emp_leaves', function (Blueprint $table) {
            $table->id();
            $table->char('emp_nik')->nullable(false);
            $table->foreign('emp_nik')->on('employees')->references('nik');
            $table->double('total')->default(0);
            $table->double('used')->default(0);
            $table->double('over')->default(0);
            $table->string('year', 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculate_emp_leaves');
    }
};
