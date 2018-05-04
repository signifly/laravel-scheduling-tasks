<?php

namespace Signifly\SchedulingTasks;

use ReflectionClass;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;

class TaskLoader
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function loadFor(Schedule $schedule, array $exclude = [])
    {
        $namespace = $this->app->getNamespace();

        $path = $this->app->path('Console/Tasks');

        if (! is_dir($path)) {
            return;
        }

        foreach ((new Finder)->in($path)->files() as $task) {
            $task = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($task->getPathname(), app_path().DIRECTORY_SEPARATOR)
            );

            if (in_array($task, $exclude)) {
                continue;
            }

            if (is_subclass_of($task, TaskContract::class) &&
                ! (new ReflectionClass($task))->isAbstract()) {

                // Invoke the task
                (new $task)($schedule);
            }
        }
    }
}
