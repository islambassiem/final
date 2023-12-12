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
    Schema::create('permissions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->unsignedTinyInteger('permission_type');
      $table->date('date');
      $table->time('from');
      $table->time('to');
      $table->string('status_id', 10);
      $table->softDeletes();
      $table->timestamps();

      // joins
      $table->foreign('permission_type')->references('id')->on('_permission_types');
      $table->foreign('status_id')->references('code')->on('_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permissions');
  }
};
