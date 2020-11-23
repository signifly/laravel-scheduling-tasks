<?php

namespace Signifly\SchedulingTasks\Test\Console\Tasks;

use Illuminate\Console\Scheduling\Schedule;
use Signifly\SchedulingTasks\TaskContract;

class BackupDaily implements TaskContract
{
    public function __invoke(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->daily()
            ->at('02:00');
    }
}
