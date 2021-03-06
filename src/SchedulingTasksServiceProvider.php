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
        if ($this->app->runningInConsole()) {
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
        $this->app->singleton(TaskLoader::class, function ($app) {
            return new TaskLoader($app);
        });

        $this->app->alias(TaskLoader::class, 'task-loader');
    }
}
