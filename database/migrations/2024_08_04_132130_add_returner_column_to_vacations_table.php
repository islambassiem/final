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
    Schema::table('vacations', function (Blueprint $table) {
      $table->boolean('returner')->after('vacation_type')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('vacations', function (Blueprint $table) {
      $table->drop('returner');
    });
  }
};
