<?php


namespace CqrsExample\Infrastructure\Database\Query;


use CommonLibrary\Infrastructure\Database\PdoQuery;

use CqrsExample\Application\Query\Dto\EmployeeDto;
use CqrsExample\Application\Query\EmployeeQueries;

class PdoEmployeeQueries extends PdoQuery implements EmployeeQueries
{

    /**
     * @param string $email
     *
     * @return EmployeeDto
     */
    public function get(string $email): EmployeeDto
    {
        $results = $this->query(
            'SELECT * FROM employees WHERE email = :email',
            [':email' => (string)$email],
            EmployeeDto::class
        );
        return array_shift($results);
    }

    /**
     * @param string $companyId
     *
     * @return EmployeeDto[]
     */
    public function getForCompany(string $companyId): array
    {
        return $this->query(
            'SELECT * FROM employees WHERE id = :id',
            [':id' => (string)$companyId],
            EmployeeDto::class
        );
    }
}