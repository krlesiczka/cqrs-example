<?php
namespace CommonLibrary\Domain;


use CommonLibrary\Application\Context\EventContext;

interface Event
{
    public function setEventContext(EventContext $eventContext);

    public function getEventContext(): EventContext;
}