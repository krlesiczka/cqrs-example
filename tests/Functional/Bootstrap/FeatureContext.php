<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use CommonLibrary\Domain\EventPublisher;
use CqrsExample\Application\Command\Handler\RegisterNewEmployeeInCompanyCommandHandler;
use CqrsExample\Application\Command\RegisterNewEmployeeInCompanyCommand;
use CqrsExample\Domain\Company;
use CqrsExample\Domain\Company\CompanyDomain;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Company\CompanyName;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Company\EmployeeRegistration\UniqueEmployeeCountRegistration;
use CqrsExample\Domain\Employee;
use CqrsExample\Domain\Employee\EmployeeEmail;
use CqrsExample\Domain\Employee\EmployeeName;
use CqrsExample\Domain\Employee\EmployeePhoneNumber;
use CqrsExample\Domain\Employee\EmployeeRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var Company
     */
    private $company;


    /**
     * @var Employee[]
     */
    private $employees;

    /**
     * @var Exception[]
     */
    private $exceptions;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }


    /**
     * @Given /^I have company (with)? (? id ":id") (? name ":name") (? domain ":domain")$/
     *
     * @param null $id
     * @param null $name
     * @param null $domain
     */
    public function iHaveCompany($id = null, $name = null, $domain = null): void
    {
        $this->company = $this->createCompany($id, $name, $domain);
    }

    /**
     * @Given My company contains employees:
     *
     * @param TableNode|null $employeesData
     */
    public function iHaveCompanyWithEmployee(TableNode $employeesData = null): void
    {
        foreach ($employeesData as $row) {
            $this->employees[] = $this->createEmployee($row['name'], $row['email'], $row['phone']);

        }
    }

    /**
     * @Given /^In my Company I register new employee with email ":email", name ":name" (? and phone ":phone")$/
     *
     * @param $email
     * @param $name
     * @param null $phone
     */
    public function iRegisterNewEmployeeInCompanyWithData($email, $name, $phone = null): void
    {
        $newEmployee = $this->createEmployee($email, $name, $phone);
        $companyId = $this->company->getId();

        $companyRepository = Mockery::mock(CompanyRepository::class);
        $companyRepository->allows()->get($companyId)->andReturns($this->company);
        $employeeRepository = Mockery::mock(EmployeeRepository::class);
        $employeeRepository->allows()->getCompanyUsers($companyId)->andReturns($this->employees);
        $eventPublisher = Mockery::mock(EventPublisher::class);
        $eventPublisher->expects()->publish($companyId);

        $handler = new RegisterNewEmployeeInCompanyCommandHandler($companyRepository, $employeeRepository, $eventPublisher);

        $command = new RegisterNewEmployeeInCompanyCommand($companyId, $newEmployee);

        try {
            $handler($command);
        } catch (Exception $exception) {
            $this->exceptions[] = $exception;
        }
    }



    private function createEmployee(string $name, string $email, ?string $phone): Employee
    {
        return new Employee(
            new EmployeeEmail($email),
            new EmployeeName($name),
            null === $phone ? new EmployeePhoneNumber($phone) : null
        );
    }

    private function createCompany(string $id = null, string $name = null, string $domain = null): Company
    {
        return new Company(
            new CompanyId($id ?? 'cb3388f5-9cd9-43c8-a4a3-16f70aa8ab22'),
            new CompanyName($name ?? 'TEST COMPANY'),
            new CompanyDomain($domain ?? 'test.domain'),
            [],
            new UniqueEmployeeCountRegistration()
        );
    }
}


