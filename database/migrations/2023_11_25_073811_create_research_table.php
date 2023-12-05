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
    Schema::create('research', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users');
      $table->unsignedTinyInteger('type_id');
      $table->unsignedTinyInteger('status_id');
      $table->unsignedTinyInteger('progress_id');
      $table->unsignedTinyInteger('nature_id');
      $table->unsignedTinyInteger('domain_id');
      $table->boolean('category_code')->default(1);
      $table->string('title')->nullable();
      $table->unsignedSmallInteger('lang_id');
      $table->unsignedSmallInteger('publication_location');

      $table->date('publishing_date')->nullable();
      $table->string('publisher')->nullable();

      $table->string('edition', 10)->nullable();
      $table->string('isbn', 100)->nullable();

      $table->string('magazine')->nullable();
      $table->string('publishing_url')->nullable();

      $table->text('summary')->nullable();
      $table->string('key_words')->nullable();
			$table->string('pages_number',5)->nullable();
      $table->softDeletes();
      $table->timestamps();


      $table->foreign('type_id')->references('id')->on('_research_types');
      $table->foreign('status_id')->references('id')->on('_research_status');
      $table->foreign('progress_id')->references('id')->on('_research_progress');
      $table->foreign('nature_id')->references('id')->on('_research_nature');
      $table->foreign('domain_id')->references('id')->on('_research_domains');
      $table->foreign('publication_location')->references('id')->on('_countries');
      $table->foreign('lang_id')->references('id')->on('_research_languages');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('research');
  }
};
