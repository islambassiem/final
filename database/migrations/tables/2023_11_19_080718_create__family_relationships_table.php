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
    Schema::create('_family_relationships', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('relationship_en', 50);
      $table->string('relationship_ar', 50);
      $table->string('code', 10);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('_family_relationships');
  }
};
