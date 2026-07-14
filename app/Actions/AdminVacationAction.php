<?php

declare(strict_types=1);

namespace App\Actions;

use App\Mail\VacationAction as MailVacationAction;
use App\Models\Vacation;
use App\Notifications\VacationAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminVacationAction
{
    public function handle(Vacation $vacation, ?string $notes = null): Vacation
    {
        $vacation = DB::transaction(function () use ($vacation, $notes) {

            $vacation->update([
                'status_id' => true,
            ]);

            $detail = $vacation->detail()->firstOrFail();

            $data = [
                'hr_status' => true,
                'hr_time' => now(),
                'hr_notes' => $notes,
            ];

            if (! $detail->head_status) {
                $data += [
                    'head_status' => true,
                    'head_time' => now(),
                    'head_notes' => 'Action taken by HR',
                ];
            }

            $detail->update($data);

            return $vacation->fresh();
        });

        $vacation->user->notify(new VacationAction($vacation));
        Mail::queue(new MailVacationAction($vacation));

        return $vacation;
    }
}
