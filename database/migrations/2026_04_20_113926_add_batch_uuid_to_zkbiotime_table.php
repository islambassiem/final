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
        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->string('batch_uuid')->nullable();
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->string('iclock_transaction_id')->nullable();
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->renameColumn('transaction', 'punch_time');
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->dropColumn('device_id');
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->string('batch_uuid')->nullable()->after('punch_time')->change();
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->string('iclock_transaction_id')->nullable()->after('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->foreignId('device_id')->nullable()->index()->after('transaction');
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->dropColumn('batch_uuid');
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->dropColumn('iclock_transaction_id');
        });

        Schema::table('zkbiotime', function (Blueprint $table) {
            $table->renameColumn('punch_time', 'transaction');
        });
    }
};
