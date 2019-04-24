<?php

namespace CqrsExample\Infrastructure\Database\Repository;


use CommonLibrary\Infrastructure\Database\PdoRepository;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Employee;
use CqrsExample\Domain\Employee\EmployeeEmail;
use CqrsExample\Domain\Employee\EmployeeName;
use CqrsExample\Domain\Employee\EmployeePhoneNumber;
use CqrsExample\Domain\Employee\EmployeeRepository;

class PdoEmployeeRepository extends PdoRepository implements EmployeeRepository
{

    /**
     * @param EmployeeEmail $employeeEmail
     *
     * @return Employee
     */
    public function get(EmployeeEmail $employeeEmail): Employee
    {
        $result = $this->query('SELECT * FROM employees WHERE email = :email', [':email' => (string)$employeeEmail]);
        $employee = array_shift($result);
        return $this->createEmployee($employee['email'], $employee['name'], $employee['phone']);
    }

    /**
     * @param CompanyId $companyId
     *
     * @return Employee[]
     */
    public function getCompanyEmployees(CompanyId $companyId): array
    {
        $result = $this->query('SELECT * FROM employees WHERE company_id = :id', [':id' => (string)$companyId]);
        $employees = [];
        foreach ($result as $employee) {
            $employees[] = $this->createEmployee($employee['email'], $employee['name'], $employee['phone']);
        }

        return $employees;
    }

    public function persist(Employee $employee): void
    {
        $result = $this->query(
            'INSERT OR REPLACE INTO employees (email, name, phone) VALUES (:email, :name, :phone);',
            [
                ':email' => (string)$employee->getEmail(),
                ':name' => (string)$employee->getName(),
                ':phone' => (string)$employee->getPhone(),
            ]
        );
    }

    private function createEmployee(string $name, string $email, ?string $phone): Employee
    {
        return new Employee(
            new EmployeeEmail($email),
            new EmployeeName($name),
            null === $phone ? new EmployeePhoneNumber($phone) : null
        );
    }

}