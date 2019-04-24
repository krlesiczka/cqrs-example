<?php

namespace CqrsExample\Domain;

use CqrsExample\Domain\Company\CompanyDomain;
use CqrsExample\Domain\Employee\EmployeeEmail;
use CqrsExample\Domain\Employee\EmployeeName;
use CqrsExample\Domain\Employee\EmployeePhoneNumber;

class Employee
{
    /**
     * @var EmployeeEmail
     */
    private $email;

    /**
     * @var EmployeeName
     */
    private $name;

    /**
     * @var EmployeePhoneNumber
     */
    private $phone;

    /**
     * Employee constructor.
     * @param EmployeeEmail $email
     * @param EmployeeName $name
     * @param EmployeePhoneNumber $phone
     */
    public function __construct(
        EmployeeEmail $email,
        EmployeeName $name,
        ?EmployeePhoneNumber $phone = null
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
    }


    public function hasEmailInCompanyDomain(CompanyDomain $domain): bool
    {
        return $this->email->isInCompanyDomain($domain);
    }

    public function equals(Employee $otherEmployee): bool
    {
        /*
         * if email match we agree this is the same employee
         */
        return $this->email->equals($otherEmployee->getEmail());
    }

    /**
     * @return EmployeeEmail
     */
    public function getEmail(): EmployeeEmail
    {
        return $this->email;
    }

    /**
     * @return EmployeeName
     */
    public function getName(): EmployeeName
    {
        return $this->name;
    }

    /**
     * @return EmployeePhoneNumber | null
     */
    public function getPhone(): ?EmployeePhoneNumber
    {
        return $this->phone;
    }
}