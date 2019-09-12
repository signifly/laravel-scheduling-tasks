<?php

namespace Signifly\SchedulingTasks\Test;

use Mockery;
use Illuminate\Foundation\Application;
use Signifly\SchedulingTasks\TaskLoader;
use Illuminate\Console\Scheduling\Schedule;
use Signifly\SchedulingTasks\Test\TestCase;
use Signifly\SchedulingTasks\Test\Console\Tasks\BackupDaily;

class SchedulingTasksTest extends TestCase
{
    protected function mockApp()
    {
        return $this->instance(Application::class, Mockery::mock(Application::class, function ($mock) {
            $mock->shouldReceive('getNamespace')
                ->once()
                ->andReturn(__NAMESPACE__ . '\\');

            $mock->shouldReceive('path')
                ->with('Console/Tasks')
                ->once()
                ->andReturn(__DIR__ . '/Console/Tasks');
            $mock->shouldReceive('path')
                ->once()
                ->andReturn(__DIR__);
        }));
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
