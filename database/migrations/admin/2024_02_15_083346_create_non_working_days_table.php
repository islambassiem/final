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
    Schema::create('non_working_days', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      $table->foreignId('month_id');
      $table->unsignedTinyInteger('type');
      $table->integer(column:'days', unsigned: true);
      $table->timestamps();


      $table->foreign('type')->references('id')->on('_vacation_types');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('non_working_days');
  }
};
