<?php

namespace CommonLibrary;


use CqrsExample\Domain\Company\CompanyName;
use CqrsExample\Domain\Employee\EmployeeEmail;
use CqrsExample\Domain\Employee\EmployeeName;

interface EmailSender
{
    public function sendWelcomeEmail(EmployeeEmail $employeeEmail, EmployeeName $employeeName, CompanyName $companyName): void;
}