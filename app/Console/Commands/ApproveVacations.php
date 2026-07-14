<?php

namespace App\Console\Commands;

use App\Actions\AdminVacationAction;
use App\Queries\GetPendingVacationsQuery;
use Illuminate\Console\Command;

class ApproveVacations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:approve-vacations {type_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve the vacations approved by the department head';

    /**
     * Execute the console command.
     */
    public function handle(
        GetPendingVacationsQuery $query,
        AdminVacationAction $action
    ): int {
        $vacations = $query->handle($this->argument('type_id'));

        $this->info("Processing {$vacations->count()} vacation(s)...");

        foreach ($vacations as $vacation) {
            $action->handle($vacation);
        }

        $this->info('Vacation approval completed.');

        return self::SUCCESS;
    }
}
