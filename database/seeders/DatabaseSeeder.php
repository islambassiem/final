<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Research;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    User::create([
      'empid' => '500322',
      'email' => 'islambassiem@inaya.edu.sa',
      'password' => Hash::make('123'),
      'gender_id' => '1',
      'nationality_id' => '18',
      'religion_id' => '1',
      'place_of_birth_id' => '18',
      'marital_status_id' => '1',
      'position_id' => '1',
      'sponsorship_id' => '1',
      'section_id' => '1',
      'category_id' => '1',
      'created_by' => '1',
      'updated_by' => '1'
    ]);
  }
}
