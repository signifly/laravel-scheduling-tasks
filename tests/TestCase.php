<?php

namespace Signifly\SchedulingTasks\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Signifly\SchedulingTasks\Facades\TaskLoader;
use Signifly\SchedulingTasks\SchedulingTasksServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:9e0yNQB60wgU/cqbP09uphPo3aglW3iQJy+u4JQgnQE=');
    }

    protected function getPackageProviders($app)
    {
        return [SchedulingTasksServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'TaskLoader' => TaskLoader::class,
        ];
    }

    /**
     * Resolve application Console Kernel implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Console\Kernel', 'Signifly\SchedulingTasks\Test\Console\Kernel');
    }
}
