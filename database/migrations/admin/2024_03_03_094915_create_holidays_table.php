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
    Schema::create('holidays', function (Blueprint $table) {
      $table->id();
      $table->date('from');
      $table->date('to');
      $table->string('description');
      $table->foreignId('branch_id');
      $table->foreignId('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('holidays');
  }
};
