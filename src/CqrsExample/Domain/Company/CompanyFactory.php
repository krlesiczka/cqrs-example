<?php


namespace CqrsExample\Domain\Company;


use CqrsExample\Domain\Company;
use CqrsExample\Domain\Company\EmployeeRegistration\UniqueEmployeeCountRegistration;
use CqrsExample\Domain\Employee;

class CompanyFactory
{
    public static function createFromData(string $id, string $name, string $domain, array $employees): Company
    {
        $registrationRules = new UniqueEmployeeCountRegistration();
        foreach ($employees as $employee) {
            if (!$employee instanceof Employee) {
                 throw new \InvalidArgumentException('Not employee on list');
            }
        }

        return new Company(
            new CompanyId($id),
            new CompanyName($name),
            new CompanyDomain($domain),
            $employees,
            $registrationRules
        );
    }
}