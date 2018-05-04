<?php

namespace Signifly\SchedulingTasks\Facades;

use Illuminate\Support\Facades\Facade;

class TaskLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'task-loader';
    }
}
