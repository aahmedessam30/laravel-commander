<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeNotificationChannelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:notification-channel {name : The name of the channel} {--force : Overwrite the channel if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->value();
            $path = app_path("NotificationChannels" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('NotificationChannels')) && !mkdir($concurrentDirectory = app_path('NotificationChannels')) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Channel already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'notification-channel', ['name' => $name, 'namespace' => 'App\NotificationChannels']);

            $this->components->info(sprintf('Notification channel [%s] created successfully.', $path));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
