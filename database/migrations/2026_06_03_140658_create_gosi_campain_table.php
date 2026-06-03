<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gosi_campain', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        $path = 'storage/gallary/gosi';
        DB::table('gosi_campain')->insert([
            ['path' => "{$path}/1.webp", 'start_date' => '2026-06-01', 'end_date' => '2026-06-03'],
            ['path' => "{$path}/2.webp", 'start_date' => '2026-06-02', 'end_date' => '2026-06-04'],
            ['path' => "{$path}/3.webp", 'start_date' => '2026-06-03', 'end_date' => '2026-06-07'],
            ['path' => "{$path}/4.webp", 'start_date' => '2026-06-04', 'end_date' => '2026-06-08'],
            ['path' => "{$path}/5.webp", 'start_date' => '2026-06-05', 'end_date' => '2026-06-09'],
            ['path' => "{$path}/6.webp", 'start_date' => '2026-06-06', 'end_date' => '2026-06-10'],
            ['path' => "{$path}/7.webp", 'start_date' => '2026-06-07', 'end_date' => '2026-06-11'],
            ['path' => "{$path}/8.webp", 'start_date' => '2026-06-08', 'end_date' => '2026-06-14'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gosi_campain');
    }
};
