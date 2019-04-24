<?php
namespace CommonLibrary\Infrastructure;

use CommonLibrary\EmailSender;
use CommonLibrary\SmsSender;
use CqrsExample\Application\Query\CompanyQueries;
use CqrsExample\Application\Query\EmployeeQueries;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;
use CqrsExample\Infrastructure\Database\Bootstrap;
use CqrsExample\Infrastructure\Database\Query\PdoCompanyQueries;
use CqrsExample\Infrastructure\Database\Repository\PdoCompanyRepository;
use CqrsExample\Infrastructure\Database\Repository\PdoEmployeeRepository;
use CqrsExample\Infrastructure\Service\EchoEmailSender;
use CqrsExample\Infrastructure\Service\EchoSmsSender;
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

            $c->add(PDOAlias::class, new PDO('sqlite:/tmp/cqrs-example.db'));
            $c->add(CompanyRepository::class, PdoCompanyRepository::class);
            $c->add(EmployeeRepository::class, PdoEmployeeRepository::class);
            $c->add(CompanyQueries::class, PdoCompanyQueries::class);
            $c->add(EmployeeQueries::class, EmployeeQueries::class);
            $c->add(SmsSender::class, EchoSmsSender::class);
            $c->add(EmailSender::class, EchoEmailSender::class);
            $c->add(Bootstrap::class, Bootstrap::class)->addArguments([PDOAlias::class]);

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
