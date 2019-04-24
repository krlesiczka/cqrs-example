<?php

namespace CqrsExample\Application\Command;

use CommonLibrary\Application\Command;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Employee;

class RegisterNewEmployeeInCompanyCommand implements Command
{
    /**
     * @var CompanyId
     */
    private $companyId;

    /**
     * @var Employee
     */
    private $employee;

    /**
     * RegisterNewEmployeeInCompanyCommand constructor.
     * @param CompanyId $companyId
     * @param Employee $employee
     */
    public function __construct(CompanyId $companyId, Employee $employee)
    {
        $this->companyId = $companyId;
        $this->employee = $employee;
    }

    public function getCompanyId(): CompanyId
    {
        return $this->companyId;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }
}