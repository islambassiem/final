<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachingStaffExport implements FromQuery, WithMapping, WithHeadings
{
  public function query()
  {
    return User::with('ats', 'gender', 'section')->where('active', '1')
      ->whereIn('category_id', [1, 2]);
  }

  public function headings(): array
  {
    return [
      'Emp ID',
      'ATS',
      'Name',
      'Gender',
      'Department',
      'Extention',
      'Email'
    ];
  }

  public function map($row): array
  {
    $extension = $row->extension($row->id);
    return [
      $row->empid,
      $row->ats->ats ?? $row->empid,
      $row->getFullEnglishNameAttribute,
      $row->gender->gender_en,
      $row->section->section_en,
      $extension,
      $row->email
    ];
  }
}