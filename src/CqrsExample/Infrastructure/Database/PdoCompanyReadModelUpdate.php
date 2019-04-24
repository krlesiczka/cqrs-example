<?php
namespace CqrsExample\Infrastructure\Database;


use CommonLibrary\Application\Command\CommandHandler;
use CommonLibrary\Infrastructure\Database\PdoRepository;
use CqrsExample\Application\Command\UpdateCompanyReadModels;

class PdoCompanyReadModelUpdate extends PdoRepository implements CommandHandler
{
    public function handle(UpdateCompanyReadModels $command): void
    {
        $company = $command->getCompany();
        $this->query(
            "INSERT OR REPLACE INTO `companies_view` (`id`, `name`, `domain`, `employeesCount`) 
                  VALUES (:id, :name, :domain, (SELECT COUNT(*) FROM employees WHERE companyId = :id));",
            [
                ':id' => (string)$company->getId(),
                ':name' => (string)$company->getName(),
                ':domain' => (string)$company->getDomain(),
            ]
        );
    }
}