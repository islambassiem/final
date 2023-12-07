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
    Schema::create('documents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->unsignedTinyInteger('document_type_id');
      $table->string('description')->nullable();
      $table->string('document_id', 50);
      $table->string('place_of_issue', 50)->nullable();
      $table->date('date_of_issue')->nullable();
      $table->date('date_of_expiry')->nullable();
      $table->unsignedTinyInteger('notification')->default(30);
      $table->timestamps();

      $table->foreign('document_type_id')->references('id')->on('_attachment_types');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('documents');
  }
};
