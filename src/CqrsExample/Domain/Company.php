<?php

namespace CqrsExample\Domain;

use CqrsExample\Domain\Company\CompanyDomain;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Company\CompanyName;
use CqrsExample\Domain\Company\EmployeeRegistration;

class Company
{
    /**
     * @var CompanyId
     */
    private $id;

    /**
     * @var CompanyName
     */
    private $name;

    /**
     * @var CompanyDomain
     */
    private $domain;

    /**
     * @var Employee[]
     */
    private $employees;

    /**
     * @var EmployeeRegistration
     */
    private $registration;

    /**
     * Company constructor.
     * @param CompanyId $id
     * @param CompanyName $name
     * @param CompanyDomain $domain
     * @param array $employees
     * @param EmployeeRegistration $registration
     */
    public function __construct(
        CompanyId $id,
        CompanyName $name,
        CompanyDomain $domain,
        array $employees,
        EmployeeRegistration $registration
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->domain = $domain;
        $this->employees = $employees;

        foreach ($this->employees as $employee) {
            $employee->assignCompany($this);
        }

        $this->registration = $registration;
        $this->registration->setEmployeesList($this->employees);
    }

    public function registerNewEmployee(Employee $employee): void
    {
        if (!$employee->hasEmailInCompanyDomain($this->domain)) {
            throw new \LogicException('Can not register user with email not in company domain '.$this->domain);
        }
        $this->registration->checkEmployeeWithList($employee);
        $employee->assignCompany($this);
        $this->employees[] = $employee;
    }

    /**
     * @return CompanyId
     */
    public function getId(): CompanyId
    {
        return $this->id;
    }

    /**
     * @return CompanyName
     */
    public function getName(): CompanyName
    {
        return $this->name;
    }

    /**
     * @return CompanyDomain
     */
    public function getDomain(): CompanyDomain
    {
        return $this->domain;
    }

    /**
     * @return Employee[]
     */
    public function getEmployees(): array
    {
        return $this->employees;
    }
}