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
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('name', 100)->nullable();
      $table->unsignedTinyInteger('type_id');
      $table->string('issuer', 100)->nullable();
      $table->date('courseDate')->nullable();
      $table->string('period', 100)->nullable();
      $table->string('city', 100)->nullable();
      $table->unsignedSmallInteger('country_id');
      $table->timestamps();


      // joins
      $table->foreign('type_id')->references('id')->on('_course_types');
      $table->foreign('country_id')->references('id')->on('_countries');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('courses');
  }
};
