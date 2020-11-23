<?php

namespace Signifly\SchedulingTasks\Test;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Mockery;
use Signifly\SchedulingTasks\TaskLoader;
use Signifly\SchedulingTasks\Test\Console\Tasks\BackupDaily;

class SchedulingTasksTest extends TestCase
{
    protected function mockApp()
    {
        $app = Mockery::mock(Application::class, function ($mock) {
            $mock->shouldReceive('getNamespace')
                ->once()
                ->andReturn(__NAMESPACE__.'\\');

            $mock->shouldReceive('path')
                ->with('Console/Tasks')
                ->once()
                ->andReturn(__DIR__.'/Console/Tasks');
            $mock->shouldReceive('path')
                ->once()
                ->andReturn(__DIR__);
        });

        $this->app->instance(Application::class, $app);
        return $app;
    }

    protected function mock($abstract, \Closure $mock = null)
    {
        return $this->instance($abstract, Mockery::mock(...array_filter(func_get_args())));
    }

    /** @test */
    public function it_skips_loading_excludes()
    {
        $app = $this->mockApp();
        $schedule = new Schedule;

        $this->mock(BackupDaily::class, function ($spy) use ($schedule) {
            $spy->shouldReceive()
                ->__invoke($schedule)
                ->never();
        });
        (new TaskLoader($app))->loadFor($schedule, [BackupDaily::class]);
    }

    /** @test */
    public function it_invokes_a_found_task()
    {
        $app = $this->mockApp();
        $schedule = new Schedule;

        $this->mock(BackupDaily::class, function ($mock) use ($schedule) {
            $mock->shouldReceive()
                ->__invoke($schedule)
                ->once();
        });
        (new TaskLoader($app))->loadFor($schedule);
    }
}
