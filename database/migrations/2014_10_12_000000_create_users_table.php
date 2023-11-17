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
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('empid')->uniqid();
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->string('head')->nullable();
      $table->string('first_name_en', 50)->nullable();
      $table->string('middle_name_en', 50)->nullable();
      $table->string('third_name_en', 50)->nullable();
      $table->string('family_name_en', 50)->nullable();
      $table->string('first_name_ar', 50)->nullable();
      $table->string('middle_name_ar', 50)->nullable();
      $table->string('third_name_ar', 50)->nullable();
      $table->string('family_name_ar', 50)->nullable();
      $table->unsignedTinyInteger('gender_id');
      $table->unsignedSmallInteger('nationality_id');
      $table->unsignedTinyInteger('religion_id');
      $table->date('date_of_birth')->nullable();
      $table->unsignedSmallInteger('place_of_birth_id');
      $table->unsignedTinyInteger('marital_status_id');
      $table->date('joining_date')->nullable();
      $table->date('resignation_date')->nullable();
      $table->unsignedSmallInteger('position_id');
      $table->unsignedSmallInteger('sponsorship_id');
      $table->unsignedSmallInteger('section_id');
      $table->unsignedTinyInteger('category_id');
      $table->boolean('active')->default(1);
      $table->boolean('salary')->default(1);
      $table->boolean('fingerprint')->default(1);
      $table->boolean('saturday')->default(1);
      $table->string('cost_center', 10)->nullable();
      $table->boolean('married_contract')->default(0);
      $table->unsignedTinyInteger('vacation_class')->default(0);
      $table->text('notes')->nullable();
      $table->unsignedTinyInteger('special_need_id')->nullable();
      $table->string('home_country_id', 50)->nullable();
      $table->foreignId('created_by')->constrained('users')->nullable();
      $table->foreignId('updated_by')->constrained('users')->nullable();
      $table->timestamps();
      /*
      -----------------------------------
      |  Joins
      -----------------------------------
      */
      $table->foreign('gender_id')->references('id')->on('_genders');
      $table->foreign('nationality_id')->references('id')->on('_countries');
      $table->foreign('religion_id')->references('id')->on('_religions');
      $table->foreign('position_id')->references('id')->on('_positions');
      $table->foreign('sponsorship_id')->references('id')->on('_sponsorships');
      $table->foreign('section_id')->references('id')->on('_sections');
      $table->foreign('category_id')->references('id')->on('_categories');
      $table->foreign('special_need_id')->references('id')->on('_special_needs');
      $table->foreign('place_of_birth_id')->references('id')->on('_countries');
      $table->foreign('marital_status_id')->references('id')->on('_marital_statuses');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
