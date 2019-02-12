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

        foreach ((new Finder)->in($path)->files() as $taskFile) {
            $taskClass = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($taskFile->getPathname(), app_path().DIRECTORY_SEPARATOR)
            );

            if (in_array($taskClass, $exclude)) {
                continue;
            }

            if (is_subclass_of($taskClass, TaskContract::class) &&
                ! (new ReflectionClass($taskClass))->isAbstract()) {
                $task = new $taskClass;

                // If the task should only run in production
                // and the application is not in production
                // then return
                if (isset($task->onlyInProduction)
                    && $task->onlyInProduction === true
                    && ! $this->app->environment('production')
                ) {
                    return;
                }

                // Invoke task
                $task($schedule);
            }
        }
    }
}
