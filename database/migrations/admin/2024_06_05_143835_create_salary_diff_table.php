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
    Schema::create('salary_diff', function (Blueprint $table) {
      $table->id();
      $table->string('empid',10);
      $table->string('month', 2);
      $table->string('year', 4);
      $table->string('name')->nullable();
      $table->float('finance')->default(0);
      $table->float('hr')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('salary_diff');
  }
};
