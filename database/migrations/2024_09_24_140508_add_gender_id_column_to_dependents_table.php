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
    Schema::table('dependents', function (Blueprint $table) {
      $table->unsignedTinyInteger('gender_id')->after('name')->nullable();
      $table->foreign('gender_id')->references('id')->on('_genders');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('dependents', function (Blueprint $table) {
      $table->drop('gender_id');
    });
  }
};
