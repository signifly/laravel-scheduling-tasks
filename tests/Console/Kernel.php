<?php

namespace Signifly\SchedulingTasks\Test\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Signifly\SchedulingTasks\Facades\TaskLoader;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        TaskLoader::loadFor($schedule);
    }
}
