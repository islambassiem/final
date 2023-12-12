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
    Schema::create('_permission_types', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('permission_type_en', 50);
      $table->string('permission_type_ar', 50);
      $table->string('permission_type_code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('_permission_types');
  }
};
