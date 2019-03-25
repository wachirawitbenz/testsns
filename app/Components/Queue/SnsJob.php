<?php
namespace App\Components\Queue;
use Exception;
use Aws\Sqs\SqsClient;
use Illuminate\Container\Container;
use Illuminate\Queue\Jobs\SqsJob;
class SnsJob extends SqsJob
{
    private $map;
    public function __construct(Container $container, SqsClient $sqs, array $job, string $connectionName, string $queue, JobMap $map)
    {
        parent::__construct($container, $sqs, $job, $connectionName, $queue);
        $this->map = $map;
    }
    public function payload()
    {
        $payload = parent::payload();
        if (! isset($payload['TopicArn'])) {
            throw new Exception(sprintf('Message with id [%s] does not have Topic ARN', $this->getJobId()));
        }
        $payload['job'] = $this->map->fromTopic($payload['TopicArn']);
        $payload['data'] = $payload['Message'];
        return $payload;
    }
}