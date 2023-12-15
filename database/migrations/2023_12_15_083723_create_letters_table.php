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
    Schema::create('letters', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('addressee');
      $table->boolean('english')->default(0);
      $table->boolean('salary')->default(0);
      $table->boolean('loan')->default(0);
      $table->boolean('attested')->default(0);
      $table->boolean('deduction')->default(0);
      $table->string('notes')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('letters');
  }
};
