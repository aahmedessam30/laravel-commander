<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeNotificationChannelCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:notification-channel {name} {--force : Overwrite the channel if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification channel';

    /**
     * The file name for the notification channel.
     *
     * @var string
     */
    protected string $fileName = 'NotificationChannel';

    /**
     * The namespace for the notification channel.
     *
     * @var string
     */
    protected string $namespace = 'App\Notifications\Channels\\';

    /**
     * Create the notification channel file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'notification-channel', [
            'name'      => $name,
            'namespace' => $namespace
        ]);
    }
}
