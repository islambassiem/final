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
    Schema::create('_banks', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('bank_name_en', 150);
      $table->string('bank_name_ar', 150);
      $table->string('bank_code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('_banks');
  }
};
