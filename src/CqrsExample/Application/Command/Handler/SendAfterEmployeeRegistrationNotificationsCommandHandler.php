<?php

namespace CqrsExample\Application\Command\Handler;

use CommonLibrary\Application\Command\CommandHandler;
use CommonLibrary\Application\Context\EventSourceEnv;
use CommonLibrary\EmailSender;
use CommonLibrary\SmsSender;
use CqrsExample\Application\Command\SendAfterEmployeeRegistrationNotificationsCommand;
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


    public function handle(SendAfterEmployeeRegistrationNotificationsCommand $command): void
    {
        $eventContext = $command->getContext();
        if ($eventContext->getEventSourceEnv() !== EventSourceEnv::CLI) {
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
            $this->smsSender->sendWelcomeSms(
                $employee->getPhone(),
                $employee->getName(),
                $company->getName()
            );
        }
    }
}