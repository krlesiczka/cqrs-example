<?php


namespace CqrsExample\Infrastructure\Service;


use CommonLibrary\SmsSender;
use CqrsExample\Domain\Company\CompanyName;
use CqrsExample\Domain\Employee\EmployeeName;
use CqrsExample\Domain\Employee\EmployeePhoneNumber;

class EchoSmsSender implements SmsSender
{

    public function sendWelcomeSms(EmployeePhoneNumber $phoneNumber, EmployeeName $employeeName, CompanyName $companyName): void
    {
        echo "SMS to {$phoneNumber}: Dear {$employeeName} welcome in {$companyName} company\n";
    }
}