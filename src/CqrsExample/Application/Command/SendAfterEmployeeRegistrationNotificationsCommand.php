<?php

namespace CqrsExample\Application\Command;


use CommonLibrary\Command;
use CommonLibrary\Context\EventContext;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Employee\EmployeeEmail;

class SendAfterEmployeeRegistrationNotificationsCommand implements Command
{
    /**
     * @var CompanyId
     */
    private $companyId;

    /**
     * @var EmployeeEmail
     */
    private $employeeEmail;

    /**
     * @var EventContext
     */
    private $context;


    /**
     * SendAfterEmployeeRegistrationNotificationsCommand constructor.
     * @param CompanyId $companyId
     * @param EmployeeEmail $employeeEmail
     * @param EventContext $context
     */
    public function __construct(CompanyId $companyId, EmployeeEmail $employeeEmail, EventContext $context)
    {
        $this->companyId = $companyId;
        $this->employeeEmail = $employeeEmail;
        $this->context = $context;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId(): CompanyId
    {
        return $this->companyId;
    }

    /**
     * @return EmployeeEmail
     */
    public function getEmployeeEmail(): EmployeeEmail
    {
        return $this->employeeEmail;
    }

    /**
     * @return EventContext
     */
    public function getContext(): EventContext
    {
        return $this->context;
    }
}