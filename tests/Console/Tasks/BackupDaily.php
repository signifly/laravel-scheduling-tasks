<?php

namespace Signifly\SchedulingTasks\Test\Console\Tasks;

use Signifly\SchedulingTasks\TaskContract;
use Illuminate\Console\Scheduling\Schedule;

class BackupDaily implements TaskContract
{
    public function __invoke(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->daily()
            ->at('02:00');
    }
}
