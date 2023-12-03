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
    Schema::create('addresses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('type', 20);
      $table->string('building_no', 10)->nullable();
      $table->string('street_name', 50)->nullable();
      $table->string('district_name', 50)->nullable();
      $table->string('city', 50)->nullable();
      $table->unsignedSmallInteger('country_id')->nullable();
      $table->string('zip_code', 10)->nullable();
      $table->string('secondary_number', 10)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('addresses');
  }
};
