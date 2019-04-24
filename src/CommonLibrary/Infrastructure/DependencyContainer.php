<?php
namespace CommonLibrary\Infrastructure;

use CommonLibrary\EmailSender;
use CommonLibrary\SmsSender;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;
use CqrsExample\Infrastructure\Database\PdoCompanyRepository;
use CqrsExample\Infrastructure\Database\PdoEmployeeRepository;
use CqrsExample\Infrastructure\Service\EchoEmailSender;
use CqrsExample\Infrastructure\Service\EchoSmsSender;
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
            $c->delegate(new ReflectionContainer);

            $c->add(\PDO::class, function () { return new \PDO('sqlite:/tmp/cqrs-example.db'); });
            $c->add(CompanyRepository::class, PdoCompanyRepository::class);
            $c->add(EmployeeRepository::class, PdoEmployeeRepository::class);
            $c->add(SmsSender::class, EchoSmsSender::class);
            $c->add(EmailSender::class, EchoEmailSender::class);
            //TODO configure

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
