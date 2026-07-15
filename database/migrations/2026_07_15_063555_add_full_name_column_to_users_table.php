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
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name_en')
                ->storedAs("CONCAT_WS(' ', first_name_en, middle_name_en, third_name_en, family_name_en)")
                ->after('email')
                ->index();

            $table->string('full_name_ar')
                ->storedAs("CONCAT_WS(' ', first_name_ar, middle_name_ar, third_name_ar, family_name_ar)")
                ->after('full_name_en')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('full_name_en');
            $table->dropColumn('full_name_ar');
        });
    }
};
