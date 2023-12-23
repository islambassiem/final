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
      $table->unsignedTinyInteger('type_id')->nullable();
      $table->string('issuer', 100)->nullable();
      $table->date('courseDate')->nullable();
      $table->string('period', 20)->nullable();
      $table->string('city', 30)->nullable();
      $table->unsignedSmallInteger('country_id')->nullable();
      $table->softDeletes();
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
