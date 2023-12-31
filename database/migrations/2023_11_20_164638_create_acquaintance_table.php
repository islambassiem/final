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
    Schema::create('acquaintance', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('name');
      $table->string('mobile');
      $table->string('email');
      $table->string('position');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('acquaintance');
  }
};
