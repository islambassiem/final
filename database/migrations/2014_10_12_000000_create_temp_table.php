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
    Schema::create('temp', function (Blueprint $table) {
      $table->id();
      $table->string('empid',10)->uniqid();
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
      $table->unsignedTinyInteger('gender_id')->nullable();
      $table->unsignedSmallInteger('nationality_id')->nullable();
      $table->unsignedTinyInteger('religion_id')->nullable();
      $table->date('date_of_birth')->nullable()->nullable();
      $table->unsignedSmallInteger('place_of_birth_id')->nullable();
      $table->unsignedTinyInteger('marital_status_id')->nullable();
      $table->date('joining_date')->nullable()->nullable();
      $table->date('resignation_date')->nullable()->nullable();
      $table->unsignedSmallInteger('position_id')->nullable();
      $table->unsignedSmallInteger('sponsorship_id')->nullable();
      $table->unsignedSmallInteger('section_id')->nullable();
      $table->unsignedTinyInteger('category_id')->nullable();
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
      $table->unsignedBigInteger('created_by')->nullable();
      $table->unsignedBigInteger('updated_by')->nullable();
      $table->timestamps();


    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('temp');
  }
};
