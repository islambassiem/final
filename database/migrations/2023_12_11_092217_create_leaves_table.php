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
    Schema::create('leaves', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->unsignedTinyInteger('leave_type');
      $table->date('date');
      $table->time('from');
      $table->time('to');
      $table->string('status_id', 10);
      $table->softDeletes();
      $table->timestamps();

      // joins
      $table->foreign('leave_type')->references('id')->on('_leave_types');
      $table->foreign('status_id')->references('code')->on('_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('leaves');
  }
};
