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
    Schema::create('attachments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained();
      $table->unsignedTinyInteger('attachment_type');
      $table->string('link')->nullable();
      $table->string('title', 50)->nullable();
      $table->morphs('attachmentable');
      $table->softDeletes();
      $table->timestamps();

      // joins
      $table->foreign('attachment_type')->references('id')->on('_attachment_types');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attachments');
  }
};
