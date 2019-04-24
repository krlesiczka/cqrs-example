<?php

namespace CqrsExample\Application\Command\Handler;


use CommonLibrary\Application\Command\CommandHandler;
use CommonLibrary\Domain\EventPublisher;
use CqrsExample\Application\Command\RegisterNewEmployeeInCompanyCommand;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;
use CqrsExample\Domain\Event\NewEmployeeRegisteredInCompanyEvent;

class RegisterNewEmployeeInCompanyCommandHandler implements CommandHandler
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * RegisterNewEmployeeInCompanyCommandHandler constructor.
     * @param CompanyRepository $companyRepository
     * @param EmployeeRepository $employeeRepository
     * @param EventPublisher $eventPublisher
     */
    public function __construct(
        CompanyRepository $companyRepository,
        EmployeeRepository $employeeRepository,
        EventPublisher $eventPublisher
    ) {
        $this->companyRepository = $companyRepository;
        $this->employeeRepository = $employeeRepository;
        $this->eventPublisher = $eventPublisher;
    }

    public function __invoke(RegisterNewEmployeeInCompanyCommand $command): void
    {
        $company = $this->companyRepository->get($command->getCompanyId());
        $newEmployee = $command->getEmployee();

        $company->registerNewEmployee($newEmployee);

        $this->companyRepository->persist($company);

        $this->eventPublisher->publish(new NewEmployeeRegisteredInCompanyEvent($company, $newEmployee));
    }
}