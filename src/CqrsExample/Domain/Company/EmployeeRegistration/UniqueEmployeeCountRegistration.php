<?php

namespace CqrsExample\Domain\Company\EmployeeRegistration;

use CqrsExample\Domain\Company\EmployeeRegistration;
use CqrsExample\Domain\Employee;


class UniqueEmployeeCountRegistration implements EmployeeRegistration
{

    const EMPLOYEES_LIMIT = 3;

    /**
     * @var Employee[]
     */
    private $employees;


    public function setEmployeesList(array $employees): void
    {
        $this->employees = $employees;
    }

    public function checkEmployeeWithList(Employee $employee): void
    {
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
        return count($this->employees) >= self::EMPLOYEES_LIMIT;
    }
}