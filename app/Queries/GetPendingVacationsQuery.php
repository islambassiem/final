<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Vacation;

class GetPendingVacationsQuery
{
    public function handle(?int $vacation_type = null)
    {
        return Vacation::whereHas('detail', function ($q) {
            $q->where('head_status', 1)
                ->where('hr_status', 0);
        })
        ->whereNull('deleted_at')
        ->when($vacation_type, function ($q) use ($vacation_type) {
            $q->where('vacation_type', $vacation_type);
        })
        ->get();
    }
}
