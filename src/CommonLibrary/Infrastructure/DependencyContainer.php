<?php
namespace CommonLibrary\Infrastructure;

use CommonLibrary\Domain\EventPublisher;
use CommonLibrary\EmailSender;
use CommonLibrary\SmsSender;
use CqrsExample\Application\Command\Handler\SendAfterEmployeeRegistrationNotificationsCommandHandler;
use CqrsExample\Application\Query\CompanyQueries;
use CqrsExample\Application\Query\EmployeeQueries;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;
use CqrsExample\Infrastructure\Database\Bootstrap;
use CqrsExample\Infrastructure\Database\Query\PdoCompanyQueries;
use CqrsExample\Infrastructure\Database\PdoCompanyReadModelUpdate;
use CqrsExample\Infrastructure\Database\Repository\PdoCompanyRepository;
use CqrsExample\Infrastructure\Database\Repository\PdoEmployeeRepository;
use CqrsExample\Infrastructure\Event\EventsEngine;
use CqrsExample\Infrastructure\Service\EchoEmailSender;
use CqrsExample\Infrastructure\Service\EchoSmsSender;
use League\Tactician\CommandBus;
use PDO;
use PDO as PDOAlias;
use Psr\Container\ContainerInterface;
use League\Container\Container;
use League\Container\ReflectionContainer;

class DependencyContainer
{
    /**
     * @var ContainerInterface
     */
    private static $container = null;

    /**
     * @param bool $forceRebuild
     */
    public static function build(bool $forceRebuild = false): void
    {
        if (self::$container === null || $forceRebuild) {

            $c = new Container;
            $c->delegate((new ReflectionContainer)->cacheResolutions());

            $c->add(PDOAlias::class,
                function () {
                    $pdo = new PDO('sqlite:../data/cqrs-example.db');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
                    return $pdo;
                }
            );
            $c->add(CompanyRepository::class, PdoCompanyRepository::class)
                ->addArguments([PDOAlias::class, EmployeeRepository::class]);
            $c->add(EmployeeRepository::class, PdoEmployeeRepository::class)->addArguments([PDOAlias::class]);
            $c->add(EventPublisher::class, EventsEngine::class)->addArguments([CommandBus::class]);
            $c->add(EventPublisher::class, EventsEngine::class)->addArguments([CommandBus::class]);

            $c->add(SendAfterEmployeeRegistrationNotificationsCommandHandler::class, SendAfterEmployeeRegistrationNotificationsCommandHandler::class)
                ->addArguments([CompanyRepository::class, EmployeeRepository::class, EmailSender::class, SmsSender::class]);

            $c->add(PdoCompanyReadModelUpdate::class, PdoCompanyReadModelUpdate::class)->addArguments([PDOAlias::class]);
            $c->add(CompanyQueries::class, PdoCompanyQueries::class)->addArguments([PDOAlias::class]);
            $c->add(EmployeeQueries::class, EmployeeQueries::class)->addArguments([PDOAlias::class]);
            $c->add(SmsSender::class, EchoSmsSender::class);
            $c->add(EmailSender::class, EchoEmailSender::class);
            $c->add(Bootstrap::class, Bootstrap::class)->addArguments([PDOAlias::class]);

            self::$container = $c;
        }
    }


    public static function get(): ContainerInterface
    {
        if (self::$container === null) {
            self::build();
        }
        return self::$container;
    }
}
