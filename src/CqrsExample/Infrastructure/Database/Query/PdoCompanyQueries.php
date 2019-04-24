<?php


namespace CqrsExample\Infrastructure\Database\Query;


use CommonLibrary\Infrastructure\Database\PdoQuery;
use CqrsExample\Application\Query\CompanyQueries;
use CqrsExample\Application\Query\Dto\CompanyDto;

class PdoCompanyQueries extends PdoQuery implements CompanyQueries
{

    /**
     * @param string $companyId
     *
     * @return CompanyDto
     */
    public function get(string $companyId): CompanyDto
    {
        $results = $this->query(
            'SELECT * FROM companies_view WHERE id = :id',
            [':id' => (string)$companyId],
            CompanyDto::class
        );
        return array_shift($results);
    }

    /**
     * @return CompanyDto[]
     */
    public function getAll(): array
    {
        return $this->query('SELECT * FROM companies_view', [], CompanyDto::class);
    }
}