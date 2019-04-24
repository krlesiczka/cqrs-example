<?php
namespace CommonLibrary\Application\Context;

use CommonLibrary\Application\Context;

interface EventContext extends Context
{
    public function getEventSourceEnv(): EventSourceEnv;
}