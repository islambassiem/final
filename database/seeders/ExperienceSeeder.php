<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $experiences = [
      'id' => '3',
      'user_id' => '1',
      'position' => 'Position',
      'institution_id' => '33',
      'college_id' => '23',
      'city_id' => '1080',
      'section_id' => '227',
      'major_id' => '548',
      'minor_id' => '548',
      'academic_rank_id' => '3',
      'professional_rank_id' => '24',
      'hiring_date' => '2023-11-28',
      'joining_date' => '2023-11-28',
      'resignation_date' => '2023-11-28',
      'appointment_type_id' => '2',
      'employment_status_id' => '4',
      'tasks' => '1. Task 1
        2. Task 2
        3. Task 3
        4. Task 4
        5. Task 5',
      'job_type_id' => '4',
      'accommodation_status_id' => '1',
      'created_at' => '2023-11-28 09:24:54',
      'updated_at' => '2023-11-28 09:24:54'];

    Experience::create($experiences);
  }
}
