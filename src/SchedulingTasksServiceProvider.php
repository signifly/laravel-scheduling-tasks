<?php

namespace Signifly\SchedulingTasks;

use Illuminate\Support\ServiceProvider;
use Signifly\SchedulingTasks\Commands\TaskMakeCommand;

class SchedulingTasksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->container->runningInConsole()) {
            $this->commands([
                TaskMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton(TaskLoader::class, function ($app) {
            return new TaskLoader($app);
        });

        $this->container->alias(TaskLoader::class, 'task-loader');
    }
}
