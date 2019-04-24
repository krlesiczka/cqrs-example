<?php

namespace CqrsExample\Domain\Employee;

use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Employee;

interface EmployeeRepository
{

    /**
     * @param EmployeeEmail $employeeEmail
     *
     * @return Employee
     */
    public function get(EmployeeEmail $employeeEmail): Employee;


    /**
     * @param CompanyId $companyId
     *
     * @return Employee[]
     */
    public function getCompanyEmployees(CompanyId $companyId): array;


    /**
     * @param Employee $employee
     */
    public function persist(Employee $employee): void;
}