<?php

namespace CqrsExample\Application\Command;


use CommonLibrary\Application\Command\CommandHandler;
use CommonLibrary\Context\EventSourceEnv;
use CommonLibrary\EmailSender;
use CommonLibrary\SmsSender;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;

class SendAfterEmployeeRegistrationNotificationsCommandHandler implements CommandHandler
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
     * @var EmailSender
     */
    private $emailSender;

    /**
     * @var SmsSender
     */
    private $smsSender;

    /**
     * SendAfterEmployeeRegistrationNotificationsCommandHandler constructor.
     * @param CompanyRepository $companyRepository
     * @param EmployeeRepository $employeeRepository
     * @param EmailSender $emailSender
     * @param SmsSender $smsSender
     */
    public function __construct(
        CompanyRepository $companyRepository,
        EmployeeRepository $employeeRepository,
        EmailSender $emailSender,
        SmsSender $smsSender
    ) {
        $this->companyRepository = $companyRepository;
        $this->employeeRepository = $employeeRepository;
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
    }


    public function __invoke(SendAfterEmployeeRegistrationNotificationsCommand $command): void
    {
        $eventContext = $command->getContext();
        if ($eventContext->getEventSourceEnv() === EventSourceEnv::CLI) {
            return;
        }

        $employee = $this->employeeRepository->get($command->getEmployeeEmail());
        $company = $this->companyRepository->get($command->getCompanyId());

        $this->emailSender->sendWelcomeEmail(
            $employee->getEmail(),
            $employee->getName(),
            $company->getName()
        );

        if (null !== $employee->getPhone()) {
            $this->smsSender->sendWelcomeEmail(
                $employee->getPhone(),
                $employee->getName(),
                $company->getName()
            );
        }
    }
}