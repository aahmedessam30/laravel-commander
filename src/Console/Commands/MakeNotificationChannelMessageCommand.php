<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeNotificationChannelMessageCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:channel-message {name} {--force : Overwrite the channel message if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification channel message';

    /**
     * The file name for the notification channel message.
     *
     * @var string
     */
    protected string $fileName = 'ChannelMessage';

    /**
     * The namespace for the notification channel message.
     *
     * @var string
     */
    protected string $namespace = 'App\Notifications\Messages\\';

    /**
     * Create the notification channel message file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'channel-message', [
            'name'      => $name,
            'namespace' => $namespace
        ]);
    }
}
