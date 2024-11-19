<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeNotificationChannelMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:channel-message {name : The name of the channel message} {--force : Overwrite the channel message if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification channel message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->value();
            $path = app_path("NotificationChannels" . DIRECTORY_SEPARATOR . "Messages" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('NotificationChannels' . DIRECTORY_SEPARATOR . 'Messages')) && !mkdir($concurrentDirectory = app_path('NotificationChannels' . DIRECTORY_SEPARATOR . 'Messages')) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Channel message already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'channel-message', ['name' => $name, 'namespace' => 'App\NotificationChannels\Messages']);

            $this->components->info(sprintf('Notification channel message [%s] created successfully.', $path));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
