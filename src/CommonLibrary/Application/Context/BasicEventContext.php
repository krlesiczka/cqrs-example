<?php

namespace CommonLibrary\Application\Context;


class BasicEventContext implements EventContext
{
    /**
     * @var EventSourceEnv
     */
    private $eventSourceEnv;

    /**
     * BasicEventContext constructor.
     * @param EventSourceEnv $eventSourceEnv
     */
    public function __construct(EventSourceEnv $eventSourceEnv)
    {
        $this->eventSourceEnv = $eventSourceEnv;
    }


    public function getEventSourceEnv(): EventSourceEnv
    {
        return $this->eventSourceEnv;
    }
}