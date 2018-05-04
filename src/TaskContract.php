<?php

namespace Signifly\SchedulingTasks;

use Illuminate\Console\Scheduling\Schedule;

interface TaskContract
{
    public function __invoke(Schedule $schedule);
}
