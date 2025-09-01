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
    return app()->getLocale() == 'en' ? [
      'Emp ID',
      'ATS',
      'Name',
      'Gender',
      'Department',
      'Extention',
      'Email'
    ]: [
      'Emp ID',
      'ATS',
      'الاسم',
      'النوع',
      'القسم',
      'الهاتف',
      'البريد الإلكتروني'
    ];
  }

  public function map($row): array
  {
    $extension = $row->extension($row->id);
    return [
      $row->empid,
      $row->ats->ats ?? $row->empid,
      app()->getLocale() == 'en' ? $row->getFullEnglishNameAttribute : $row->getFullArabicNameAttribute,
      app()->getLocale() == 'en' ? $row->gender->gender_en : $row->gender->gender_ar,
      app()->getLocale() == 'en' ? $row->section->section_en : $row->section->section_ar,
      $extension,
      $row->email
    ];
  }
}