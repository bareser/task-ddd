<?php

namespace App\Infrastructure\Common\Bus\Middleware;

use App\Domain\Common\Event\EventCollector;
use JMS\Serializer\SerializerInterface;
use League\Tactician\Middleware;
use OldSound\RabbitMqBundle\RabbitMq\Producer;

class EventPublisherMiddleware implements Middleware
{
    /**
     * @var Producer
     */
    private $producer;

    /**
     * @var EventCollector
     */
    private $eventCollector;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(Producer $producer, EventCollector $eventCollector, SerializerInterface $serializer)
    {
        $this->producer = $producer;
        $this->producer
            ->setContentType('application/json');
        $this->eventCollector = $eventCollector;
        $this->serializer = $serializer;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $events = $this->eventCollector->events();

        foreach ($events as $event) {
            $serializedEvent = $this->serializer->serialize($event, 'json');

            $this->producer->publish($serializedEvent, $event->type());
        }

        return $returnValue;
    }
}
