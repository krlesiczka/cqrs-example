<?php

namespace CqrsExample\Application\Query;

use CqrsExample\Application\Query\Dto\EmployeeDto;

interface EmployeeQueries
{
    /**
     * @param string $id
     *
     * @return EmployeeDto[]
     */
    public function getForCompany(string $id): array;
}