<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements FromCollection, WithMapping, WithHeadings
{

  use Exportable;

  public function __construct(public Collection $employees) {}

  public function collection()
  {
    return $this->employees;
  }

  public function headings(): array
  {
    return [
      '#',
      'الاسم',
      'الجنس',
      'الجنسية',
      'الهوية',
      'تاريخ الميلاد',
      'تاريخ المباشرة',
      'تاريح الاستقالة',
      'الحالة الوظيفية',
      'التصنيف الوظيفي',
      'القسم',
      'الكفالة',
      'الايميل',
      'رقم الجوال',
    ];
  }

  public function map($user): array
  {
    return [
      $user->empid,
      $user->getFullArabicNameAttribute,
      $user->gender->gender_ar,
      $user->nationality->country_ar,
      $user->iqama($user->id)->document_id,
      $user->date_of_birth,
      $user->joining_date,
      $user->resignation_date,
      $user->active == 1 ? 'علي رأس العمل' : 'ترك العمل',
      $user->category->category_ar,
      $user->section->section_ar,
      $user->sponsorship->sponsorship_ar,
      $user->email,
      $user->mobile($user->id) ? '0' . $user->mobile($user->id) : null
    ];
  }
}
