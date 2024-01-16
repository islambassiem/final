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
    Schema::create('payslips', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      $table->foreignId('month_id');
      $table->integer('days', false , true);
      $table->unsignedTinyInteger('type');
      $table->timestamps();

      $table->foreign('type')->on('_vacation_types')->references('id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('payslips');
  }
};
