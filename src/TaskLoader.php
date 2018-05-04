<?php

namespace Signifly\SchedulingTasks;

use ReflectionClass;
use Illuminate\Support\Arr;
use Symfony\Component\Finder\Finder;
use Illuminate\Console\Scheduling\Schedule;

class TaskLoader
{
    public static function loadFor($paths, Schedule $schedule)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($paths)->files() as $task) {
            $task = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($task->getPathname(), app_path().DIRECTORY_SEPARATOR)
            );

            if (is_subclass_of($task, TaskContract::class) &&
                ! (new ReflectionClass($task))->isAbstract()) {
                $task($schedule);
            }
        }
    }
}
