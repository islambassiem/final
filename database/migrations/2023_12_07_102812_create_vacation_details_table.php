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
    Schema::create('vacation_details', function (Blueprint $table) {
      $table->id();
      $table->foreignId('vacation_id')->constrained('vacations');
      $table->string('employee_notes')->nullable();
      $table->timestamp('employee_time')->nullable();
      $table->string('head_status', 10);
      $table->string('head_notes')->nullable();
      $table->timestamp('head_time')->nullable();
      $table->string('hr_status', 10);
      $table->string('hr_notes')->nullable();
      $table->timestamp('hr_time')->nullable();
      $table->softDeletes();
      $table->timestamps();

      // joins
      $table->foreign('head_status')->references('code')->on('_workflow_status');
      $table->foreign('hr_status')->references('code')->on('_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vacation_details');
  }
};
