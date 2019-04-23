<?php

namespace CqrsExample\Domain;

use CqrsExample\Domain\Company\CompanyDomain;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Company\CompanyName;

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
     * Company constructor.
     * @param CompanyId $id
     * @param CompanyName $name
     * @param CompanyDomain $domain
     */
    public function __construct(CompanyId $id, CompanyName $name, CompanyDomain $domain)
    {
        $this->id = $id;
        $this->name = $name;
        $this->domain = $domain;
    }

    public function registerNewEmployee(Employee $employee): void
    {
        //TODO exceptions
        if (!$employee->hasEmailInCompanyDomain($this->domain)) {
            throw new \LogicException('Can not register user with email not in company domain '.$this->domain);
        }
        if ($this->employeesListIsFull()) {
            throw new \LogicException('Can not register because company employees list is full');
        }
        if ($this->employeeIsOnList($employee)) {
            throw new \LogicException('Can not register because employees is already registered');
        }
        $this->employees[] = $employee;
    }

    private function employeeIsOnList(Employee $checkedEmployee): bool
    {
        foreach ($this->employees as $employee) {
            if ($employee->equals($checkedEmployee)) {
                return true;
            }
        }
        return false;
    }

    private function employeesListIsFull(): bool
    {
        return count($this->employees) >= 10;
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
}