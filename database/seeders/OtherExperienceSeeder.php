<?php

namespace Database\Seeders;

use App\Models\OtherExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtherExperienceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $other_experiences = [
      'id' => '1',
      'user_id' => '71',
      'profession' =>
      'Assistant Researcher',
      'organization_name' =>
      'National Institute of Oceanography and Fisheries (NIOF Alex)',
      'city' => 'Alexandria',
      'country_id' => '18',
      'department' => 'Spectroscopy Laboratory',
      'section' => 'Central Lab',
      'start_date' => '2008-04-01',
      'end_date' => '2010-06-05',
      'deleted_at' => NULL,
      'created_at' => '2023-12-27 23:54:40',
      'updated_at' => '2023-12-27 23:54:40'
    ];

    OtherExperience::create($other_experiences);
  }
}
