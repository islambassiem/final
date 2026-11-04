<?php

declare(strict_types=1);

namespace App\Classes;


use Illuminate\Support\Facades\DB;

class GetInsuranceId
{
    public static function handle($iqamaNumber): string 
    {
        return DB::table('insurance_numbers')
            ->where('iqama_number', $iqamaNumber)
            ->value('insurance_number') ?? '';
    }
}