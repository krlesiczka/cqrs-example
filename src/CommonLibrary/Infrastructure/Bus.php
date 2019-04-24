<?php

namespace CommonLibrary\Infrastructure;

use CqrsExample\Application\Command\Handler\RegisterNewEmployeeInCompanyCommandHandler;
use CqrsExample\Application\Command\Handler\SendAfterEmployeeRegistrationNotificationsCommandHandler;
use CqrsExample\Application\Command\RegisterNewEmployeeInCompanyCommand;
use CqrsExample\Application\Command\SendAfterEmployeeRegistrationNotificationsCommand;
use CqrsExample\Application\Command\UpdateCompanyReadModels;
use CqrsExample\Application\Event\Handler\NewEmployeeRegisteredInCompanyEventHandler;
use CqrsExample\Application\Event\NewEmployeeRegisteredInCompanyEvent;
use CqrsExample\Infrastructure\Database\PdoCompanyReadModelUpdate;
use League\Container\Container;
use League\Tactician\CommandBus;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;


class Bus
{
    /**
     * @var CommandBus
     */
    private static $bus = null;

    /**
     * @param bool $forceRebuild
     */
    public static function build(bool $forceRebuild = false): void
    {
        if (self::$bus === null || $forceRebuild) {

            $commandToHandlerMap = [
                RegisterNewEmployeeInCompanyCommand::class => RegisterNewEmployeeInCompanyCommandHandler::class,
                SendAfterEmployeeRegistrationNotificationsCommand::class => SendAfterEmployeeRegistrationNotificationsCommandHandler::class,

                //TODO implement event handler
                NewEmployeeRegisteredInCompanyEvent::class => NewEmployeeRegisteredInCompanyEventHandler::class,

                UpdateCompanyReadModels::class => PdoCompanyReadModelUpdate::class,
            ];
            /** @var Container $dependencyContainer */
            $dependencyContainer = DependencyContainer::get();

            $containerLocator = new ContainerLocator(
                $dependencyContainer,
                $commandToHandlerMap
            );

            $commandHandlerMiddleware = new CommandHandlerMiddleware(
                new ClassNameExtractor(),
                $containerLocator,
                new HandleInflector()
            );

            $commandBus = new CommandBus(
                [
                    $commandHandlerMiddleware,
                ]
            );

            $dependencyContainer->add(CommandBus::class, $commandBus, true);

            self::$bus = $commandBus;
        }
    }

    /**
     * @return CommandBus
     */
    public static function get(): CommandBus
    {
        if (self::$bus === null) {
            self::build();
        }
        return self::$bus;
    }
}