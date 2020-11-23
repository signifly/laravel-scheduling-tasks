<?php

namespace Signifly\SchedulingTasks;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class TaskLoader
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->container = $app;
    }

    public function loadFor(Schedule $schedule, array $exclude = [])
    {
        $namespace = $this->container->getNamespace();

        $path = $this->container->path('Console/Tasks');

        if (! is_dir($path)) {
            return;
        }

        foreach ((new Finder)->in($path)->files() as $taskFile) {
            $task = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($taskFile->getPathname(), app_path().DIRECTORY_SEPARATOR)
            );

            if (in_array($task, $exclude)) {
                continue;
            }

            if (is_subclass_of($task, TaskContract::class) &&
                ! (new ReflectionClass($task))->isAbstract()) {

                // Invoke task
                (new $task)($schedule);
            }
        }
    }
}
