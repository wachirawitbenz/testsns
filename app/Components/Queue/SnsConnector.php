<?php
namespace App\Components\Queue;
use Aws\Sqs\SqsClient;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Queue\Connectors\SqsConnector;
use Illuminate\Support\Arr;
class SnsConnector extends SqsConnector implements ConnectorInterface
{
    private $map;
    public function __construct(JobMap $map)
    {
        $this->map = $map;
    }
    public function connect(array $config)
    {
        $config = $this->getDefaultConfiguration($config);
        if ($config['key'] && $config['secret']) {
            $config['credentials'] = Arr::only($config, ['key', 'secret', 'token']);
        }
        return new SnsQueue(
            new SqsClient($config), $config['queue'], $this->map
        );
    }
}