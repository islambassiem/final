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
    Schema::create('qualifications', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained();
      $table->unsignedTinyInteger('qualification');
      $table->string('thesis')->nullable();
      $table->unsignedSmallInteger('major_id');
      $table->unsignedSmallInteger('minor_id');
      $table->unsignedTinyInteger('rating');
      $table->string('gpa', 10);
      $table->unsignedTinyInteger('gpa_type');
      $table->unsignedTinyInteger('study_type');
      $table->string('graduation_university');
      $table->string('graduation_college');
      $table->date('graduation_date');
      $table->string('city');
      $table->unsignedSmallInteger('graduation_country');
      $table->unsignedTinyInteger('study_nature');
      $table->boolean('attested');
      $table->softDeletes();
      $table->timestamps();

      /*
        -----------------------------------
        |  Joins
        -----------------------------------
      */

      $table->foreign('qualification')->references('id')->on('_qualifications');
      $table->foreign('major_id')->references('id')->on('_specialties');
      $table->foreign('minor_id')->references('id')->on('_specialties');
      $table->foreign('rating')->references('id')->on('_ratings');
      $table->foreign('gpa_type')->references('id')->on('_gpa_types');
      $table->foreign('study_type')->references('id')->on('_study_types');
      $table->foreign('graduation_country')->references('id')->on('_countries');
      $table->foreign('study_nature')->references('id')->on('_study_natures');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('qualifications');
  }
};
