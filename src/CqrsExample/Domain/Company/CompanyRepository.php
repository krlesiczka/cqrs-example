<?php

namespace CqrsExample\Domain\Company;

use CqrsExample\Domain\Company;

interface CompanyRepository
{
    /**
     * @param CompanyId $companyId
     *
     * @return Company
     */
    public function get(CompanyId $companyId): Company;

    public function persist(Company $company): void;
}