<?php
namespace CommonLibrary\Domain;


interface EventPublisher
{
    public function publish(Event $event): void;
}