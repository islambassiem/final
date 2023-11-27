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
    Schema::create('experiences', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('position', 100)->nullable();
      $table->unsignedTinyInteger('institution_id')->nullable();
      $table->unsignedSmallInteger('college_id')->nullable();
      $table->unsignedSmallInteger('city_id')->nullable();
      $table->unsignedSmallInteger('section_id')->nullable();
      $table->unsignedSmallInteger('major_id')->nullable();
      $table->unsignedSmallInteger('minor_id')->nullable();
      $table->unsignedTinyInteger('academic_rank_id')->nullable();
      $table->unsignedTinyInteger('professional_rank_id')->nullable();
      $table->date('hiring_date')->nullable();
      $table->date('joining_date')->nullable();
      $table->date('resignation_date')->nullable();
      $table->unsignedTinyInteger('appointment_type_id')->nullable();
      $table->unsignedTinyInteger('employment_status_id')->nullable();
      $table->text('tasks')->nullable();
      $table->unsignedTinyInteger('job_type_id')->nullable();
      $table->unsignedTinyInteger('accommodation_status_id')->nullable();
      $table->timestamps();


      //joins
      $table->foreign('institution_id')->references('id')->on('_educational_institutions');
      $table->foreign('city_id')->references('id')->on('_cities');
      $table->foreign('college_id')->references('id')->on('_colleges');
      $table->foreign('section_id')->references('id')->on('_academic_sections');
      $table->foreign('major_id')->references('id')->on('_specialties');
      $table->foreign('minor_id')->references('id')->on('_specialties');
      $table->foreign('academic_rank_id')->references('id')->on('_academic_ranks');
      $table->foreign('professional_rank_id')->references('id')->on('_professional_ranks');
      $table->foreign('appointment_type_id')->references('id')->on('_appointment_types');
      $table->foreign('employment_status_id')->references('id')->on('_employment_status');
      $table->foreign('job_type_id')->references('id')->on('_job_types');
      $table->foreign('accommodation_status_id')->references('id')->on('_accommodation_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('experiences');
  }
};
