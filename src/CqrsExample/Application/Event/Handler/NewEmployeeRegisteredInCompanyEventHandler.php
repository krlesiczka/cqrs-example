<?php


namespace CqrsExample\Application\Event\Handler;

use CqrsExample\Application\Command\SendAfterEmployeeRegistrationNotificationsCommand;
use CqrsExample\Application\Event\NewEmployeeRegisteredInCompanyEvent;
use League\Tactician\CommandBus;

class NewEmployeeRegisteredInCompanyEventHandler
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * NewEmployeeRegisteredInCompanyEventHandler constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(NewEmployeeRegisteredInCompanyEvent $event): void
    {
        $notifications = new SendAfterEmployeeRegistrationNotificationsCommand(
            $event->getCompany()->getId(),
            $event->getEmployee()->getEmail(),
            $event->getEventContext()
        );
        $this->commandBus->handle($notifications);

        //TODO read model refresh
    }
}