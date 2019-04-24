<?php


namespace CqrsExample\Application\Command;

use CqrsExample\Domain\Company;

class UpdateCompanyReadModels
{
    /**
     * @var Company
     */
    private $company;

    /**
     * NewEmployeeRegisteredInCompanyEvent constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }
}