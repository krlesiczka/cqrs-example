<?php


namespace CqrsExample\Domain\Event;


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
}