<?php
namespace CommonLibrary\Context;

use CommonLibrary\Context;

interface EventContext extends Context
{
    public function getEventSourceEnv(): EventSourceEnv;
}