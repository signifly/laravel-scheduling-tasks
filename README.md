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

It generates a new task `app/Console/Tasks/BackupDaily`.

## Documentation
Until further documentation is provided, please have a look at the tests.

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
