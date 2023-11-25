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
    Schema::create('_research_domains', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('research_domain_en', 50);
      $table->string('research_domain_ar', 50);
      $table->string('code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('_research_domains');
  }
};
