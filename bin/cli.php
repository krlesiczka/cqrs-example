<?php
namespace CliTest;

require_once __DIR__.'/../vendor/autoload.php';

use CommonLibrary\Infrastructure\Bus;
use CommonLibrary\Infrastructure\DependencyContainer;
use CqrsExample\Application\Command\RegisterNewEmployeeInCompanyCommand;
use CqrsExample\Application\Query\CompanyQueries;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Employee;
use CqrsExample\Domain\Employee\EmployeeEmail;
use CqrsExample\Domain\Employee\EmployeeName;
use CqrsExample\Infrastructure\Database\Bootstrap;
use League\Tactician\CommandBus;

if (count($argv) < 2) {
    die('Usage: php cli.php command arg1 arg2');
}

$container = DependencyContainer::get();
$commandBus = Bus::get();

switch ($argv[1]) {

    case 'bootstrap':
        $bootstrap = $container->get(Bootstrap::class);
        $bootstrap->run();
        echo "Database bootstrap finished\n";
        break;

    case 'print_companies_list':
        $companies = $container->get(CompanyQueries::class);
        $list = $companies->getAll();
        echo json_encode($list, JSON_PRETTY_PRINT)."\n";
        break;

    case 'print_company':
        $companies = $container->get(CompanyQueries::class);
        $list = $companies->get($argv[2]);
        echo json_encode($list, JSON_PRETTY_PRINT)."\n";
        break;

    case 'register_employee':
        $command = new RegisterNewEmployeeInCompanyCommand(
            new CompanyId($argv[2]),
            new Employee(
                new EmployeeEmail($argv[3]),
                new EmployeeName($argv[4]),
                null === $argv[5] ? new EmployeePhoneNumber($argv[5]) : null
            )
        );
        $commandBus->handle($command);
        echo "New employee registered in company\n";
        break;
}
