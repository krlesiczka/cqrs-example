<?php

namespace CqrsExample\Domain\Company;


use CqrsExample\Domain\Employee;

interface EmployeeRegistration
{
    public function setEmployeesList(array $employees): void;

    public function checkEmployeeWithList(Employee $employee): void;
}