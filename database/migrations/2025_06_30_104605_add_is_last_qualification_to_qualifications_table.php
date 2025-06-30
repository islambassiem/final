<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('qualifications', function (Blueprint $table) {
      $table->boolean('is_last_qualification')->default(0)->after('qualification');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('qualifications', function (Blueprint $table) {
      $table->dropColumn('is_last_qualification');
    });
  }
};
