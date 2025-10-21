<?php

namespace Database\Seeders;

use App\Models\InsurnaceClass;
use Illuminate\Database\Seeder;

class InsurnaceClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InsurnaceClass::create(['name_en' => 'VVIP', 'name_ar' => 'VVIP']);
        InsurnaceClass::create(['name_en' => 'VIP+', 'name_ar' => 'VIP+']);
        InsurnaceClass::create(['name_en' => 'VVIP Single Female Employee with Parents', 'name_ar' => 'VVIP موظفة عزباء مع والديها']);
        InsurnaceClass::create(['name_en' => 'VIP+ Single Female Employee with Parents', 'name_ar' => 'VIP+ موظفة عزباء مع والديها']);
        InsurnaceClass::create(['name_en' => 'VIP Single Female Employee with Parents', 'name_ar' => 'VIP موظفة عزباء مع والديها']);
        InsurnaceClass::create(['name_en' => 'A Single Female Employee with Parents', 'name_ar' => 'A موظفة عزباء مع والديها']);
        InsurnaceClass::create(['name_en' => 'A+', 'name_ar' => 'A+']);
        InsurnaceClass::create(['name_en' => 'A+ Single Female Employee with Parents', 'name_ar' => 'A+ موظفة عزباء مع والديها']);
        InsurnaceClass::create(['name_en' => 'VIP', 'name_ar' => 'VIP']);
        InsurnaceClass::create(['name_en' => 'A', 'name_ar' => 'A']);
        InsurnaceClass::create(['name_en' => 'B', 'name_ar' => 'B']);
        InsurnaceClass::create(['name_en' => 'VVIP Single Female Employee without Maternity', 'name_ar' => 'VVIP موظفة عزباء بدون أمومة']);
        InsurnaceClass::create(['name_en' => 'VIP+ Single Female Employee without Maternity', 'name_ar' => 'VIP+ موظفة عزباء بدون أمومة']);
        InsurnaceClass::create(['name_en' => 'VIP Single Female Employee without Maternity', 'name_ar' => 'VIP موظفة عزباء بدون أمومة']);
        InsurnaceClass::create(['name_en' => 'A Single Female Employee without Maternity', 'name_ar' => 'A موظفة عزباء بدون أمومة']);
        InsurnaceClass::create(['name_en' => 'B Single Female Employee without Maternity', 'name_ar' => 'B موظفة عزباء بدون أمومة']);
    }
}
