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
      $table->unsignedTinyInteger('type_id')->nullable();
      $table->unsignedTinyInteger('status_id')->nullable();
      $table->unsignedTinyInteger('progress_id')->nullable();
      $table->unsignedTinyInteger('nature_id')->nullable();
      $table->unsignedTinyInteger('domain_id')->nullable();
      $table->boolean('citation_type')->nullable();
      $table->string('title')->nullable();
      $table->unsignedSmallInteger('lang_id')->nullable();
      $table->string('publication_location', 100)->nullable();

      $table->date('publishing_date')->nullable();
      $table->string('publisher', 60)->nullable();

      $table->string('edition', 10)->nullable();
      $table->string('isbn', 13)->nullable();

      $table->string('magazine', 100)->nullable();
      $table->string('publishing_url', 1000)->nullable();

      $table->text('summary')->nullable();
      $table->string('key_words', 200)->nullable();
			$table->string('pages_number',5)->nullable();
      $table->softDeletes();
      $table->timestamps();


      $table->foreign('type_id')->references('id')->on('_research_types');
      $table->foreign('status_id')->references('id')->on('_research_status');
      $table->foreign('progress_id')->references('id')->on('_research_progress');
      $table->foreign('nature_id')->references('id')->on('_research_nature');
      $table->foreign('domain_id')->references('id')->on('_research_domains');
      $table->foreign('citation_type')->references('id')->on('_citation_types');
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
