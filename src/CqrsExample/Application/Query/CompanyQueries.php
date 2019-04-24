<?php

namespace CqrsExample\Application\Query;

use CqrsExample\Application\Query\Dto\CompanyDto;

interface CompanyQueries
{
    /**
     * @param string $id
     *
     * @return CompanyDto
     */
    public function get(string $id): CompanyDto;

    /**
     * @return CompanyDto[]
     */
    public function getAll(): array;
}