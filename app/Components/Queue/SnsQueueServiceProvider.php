<?php
namespace App\Components\Queue;
use Illuminate\Config\Repository;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;
class SnsQueueServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->afterResolving(QueueManager::class, function (QueueManager $manager) {
            $config = $this->app->make(Repository::class);
            $manager->addConnector('sns', function () use ($config) {
                $map = new JobMap($config->get('queue.map'));
                return new SnsConnector($map);
            });
        });
    }
}