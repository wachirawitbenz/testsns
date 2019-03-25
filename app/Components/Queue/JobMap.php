<?php
namespace App\Components\Queue;
use Exception;
class JobMap
{
    private $map;
    public function __construct(array $map)
    {
        $this->map = $map;
    }
    public function fromTopic(string $topic): string
    {
        $job = array_search($topic, $this->map);
        if (! $job) {
            throw new Exception("Topic $topic is not mapped to any Job");
        }
        return $job;
    }
}