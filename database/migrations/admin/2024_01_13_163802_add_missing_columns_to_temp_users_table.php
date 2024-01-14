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
    Schema::table('temp_users', function (Blueprint $table) {
      $table->string('place_of_issue1', 50)->nullable();
      $table->date('date_of_issue1')->nullable();
      $table->date('date_of_expiry1')->nullable();
      $table->string('document_id2', 50)->nullable();
      $table->string('place_of_issue2', 50)->nullable();
      $table->date('date_of_issue2')->nullable();
      $table->date('date_of_expiry2')->nullable();
      $table->string('document_id')->nullable()->change();
      $table->float('basic')->nullable()->change();
      $table->float('housing')->nullable()->change();
      $table->float('transportation')->nullable()->change();
      $table->float('food')->nullable()->change();
      $table->float('ticket')->nullable();
      $table->unsignedTinyInteger('bank_code')->nullable()->change();;
      $table->string('iban')->nullable()->change();
      $table->string('mobile', 100)->nullable()->change();
      $table->string('personal_email', 100)->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('temp_users', function (Blueprint $table) {
      $table->dropColumn('place_of_issue1');
      $table->dropColumn('date_of_issue1');
      $table->dropColumn('date_of_expiry1');
      $table->dropColumn('document_id2');
      $table->dropColumn('place_of_issue2');
      $table->dropColumn('date_of_issue2');
      $table->dropColumn('date_of_expiry2');
      $table->dropColumn('ticket');
      $table->string('document_id')->change();
      $table->float('basic')->change();
      $table->float('housing')->change();
      $table->float('transportation')->change();
      $table->float('food')->change();
      $table->unsignedTinyInteger('bank_code')->change();;
      $table->string('iban')->change();
      $table->string('mobile', 100)->change();
      $table->string('personal_email', 100)->change();
    });
  }
};
