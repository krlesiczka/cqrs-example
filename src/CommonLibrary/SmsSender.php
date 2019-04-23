<?php

namespace CommonLibrary;

use CqrsExample\Domain\Company\CompanyName;
use CqrsExample\Domain\Employee\EmployeeName;
use CqrsExample\Domain\Employee\EmployeePhoneNumber;

interface SmsSender
{
    public function sendWelcomeEmail(EmployeePhoneNumber $phoneNumber, EmployeeName $employeeName, CompanyName $companyName): void;
}