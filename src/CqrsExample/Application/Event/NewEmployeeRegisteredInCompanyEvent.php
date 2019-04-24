<?php


namespace CqrsExample\Application\Event;


use CommonLibrary\Application\Context\EventContext;
use CommonLibrary\Domain\Event;
use CqrsExample\Domain\Company;
use CqrsExample\Domain\Employee;

class NewEmployeeRegisteredInCompanyEvent implements Event
{
    /**
     * @var Company
     */
    private $company;

    /**
     * @var Employee
     */
    private $employee;

    /**
     * @var EventContext
     */
    private $eventContext;

    /**
     * NewEmployeeRegisteredInCompanyEvent constructor.
     * @param Company $company
     * @param Employee $employee
     */
    public function __construct(Company $company, Employee $employee)
    {
        $this->company = $company;
        $this->employee = $employee;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    /**
     * @return EventContext
     */
    public function getEventContext(): EventContext
    {
        return $this->eventContext;
    }

    /**
     * @param EventContext $eventContext
     */
    public function setEventContext(EventContext $eventContext): void
    {
        $this->eventContext = $eventContext;
    }

}