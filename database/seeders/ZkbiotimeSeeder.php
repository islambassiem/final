<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Zkbiotime;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZkbiotimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()
            ->where('active', 1)
            ->where('fingerprint', 1)
            ->get();

        $dates = CarbonPeriod::create('2026-04-01', '2026-04-18');

        foreach ($users as $user) {
            foreach ($dates as $date) {

                for ($i=0; $i < fake()->numberBetween(1, 4); $i++) { 
                    Zkbiotime::create([
                        'empid' => $user->empid,
                        'transaction' => (new \DateTime($date->format('Y-m-d') . fake()->time()))->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
