<?php


namespace CqrsExample\Infrastructure\Service;


use CommonLibrary\EmailSender;
use CqrsExample\Domain\Company\CompanyName;
use CqrsExample\Domain\Employee\EmployeeEmail;
use CqrsExample\Domain\Employee\EmployeeName;

class EchoEmailSender implements EmailSender
{

    public function sendWelcomeEmail(EmployeeEmail $employeeEmail, EmployeeName $employeeName, CompanyName $companyName): void
    {
        echo "E-mail to {$employeeEmail}: Dear {$employeeName} welcome in {$companyName} company";
    }
}