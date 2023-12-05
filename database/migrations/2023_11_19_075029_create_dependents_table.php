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
    Schema::create('dependents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->string('name')->nullable();
      $table->string('identification', 50)->nullable();
      $table->date('date_of_birth')->nullable();
      $table->unsignedTinyInteger('relationship_id');
      $table->boolean('ticket')->default(0);
      $table->softDeletes();
      $table->timestamps();

      // joins
      $table->foreign('relationship_id')->references('id')->on('_family_relationships');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dependents');
  }
};
