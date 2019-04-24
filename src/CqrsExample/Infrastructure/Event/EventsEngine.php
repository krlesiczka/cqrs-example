<?php

namespace CqrsExample\Infrastructure\Event;

use CommonLibrary\Application\Context\BasicEventContext;
use CommonLibrary\Application\Context\EventSourceEnv;
use CommonLibrary\Domain\Event;
use CommonLibrary\Domain\EventPublisher;
use League\Tactician\CommandBus;

class EventsEngine implements EventPublisher
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * NewEmployeeRegisteredInCompanyEventHandler constructor.
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function publish(Event $event): void
    {
        $context = new BasicEventContext(EventSourceEnv::fromSapi());
        $event->setEventContext($context);
        $this->bus->handle($event);
    }
}