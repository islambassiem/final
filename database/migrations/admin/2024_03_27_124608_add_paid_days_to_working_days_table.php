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
    Schema::table('working_days', function (Blueprint $table) {
      $table->unsignedSmallInteger('paid_days')->after('working_days')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('working_days', function (Blueprint $table) {
      $table->dropColumn('paid_days');
    });
  }
};
