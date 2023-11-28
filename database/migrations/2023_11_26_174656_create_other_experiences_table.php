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
    Schema::create('other_experiences', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('profession', 100)->nullable();
      $table->string('organization_name', 100)->nullable();
      $table->string('city', 100)->nullable();
      $table->unsignedSmallInteger('country_id');
      $table->string('department', 100)->nullable();
      $table->string('section', 100)->nullable();
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->text('functional_tasks')->nullable();
      $table->timestamps();


      // joins
      $table->foreign('country_id')->references('id')->on('_countries');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('other_experiences');
  }
};
