# Organize your Laravel scheduling tasks

The `signifly/laravel-scheduling-tasks` package allows you to easily organize your scheduling tasks and comes with a handy `make:task` command.

Below is a small example of how to use it.

```php
// Inside the app/Console/Kernel.php file add this
use Signifly\SchedulingTasks\Facades\TaskLoader;

protected function schedule(Schedule $schedule)
{
    TaskLoader::loadFor($schedule);
}
```

In order to make a new task, use the command that comes with the package:

```bash
$ php artisan make:task BackupDaily
```

It generates a new task located at `app/Console/Tasks/BackupDaily.php`, which can be configured this way:

```php
<?php

namespace App\Console\Tasks;

use Signifly\SchedulingTasks\TaskContract;
use Illuminate\Console\Scheduling\Schedule;

class BackupDaily implements TaskContract
{
    public function __invoke(Schedule $schedule)
    {
        $schedule->command('backup:run')
            ->daily()
            ->at('01:00');
    }
}
```

In case you have a task that you want to exclude from getting loaded, it can be achieved like this:

```php
protected function schedule(Schedule $schedule)
{
    TaskLoader::loadFor($schedule, [
        \App\Console\Tasks\BackupDaily::class,
    ]);

    // \App\Console\Tasks\BackupDaily::class will not get loaded.
}
```


## Installation

You can install the package via composer:

```bash
$ composer require signifly/laravel-scheduling-tasks
```

The package will automatically register itself.

## Testing
```bash
$ composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
