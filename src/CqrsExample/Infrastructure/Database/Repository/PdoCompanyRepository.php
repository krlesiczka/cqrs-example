<?php


namespace CqrsExample\Infrastructure\Database\Repository;


use CommonLibrary\Infrastructure\Database\PdoRepository;
use CqrsExample\Domain\Company;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Company\CompanyFactory;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;
use PDO as PDOAlias;

class PdoCompanyRepository extends PdoRepository implements CompanyRepository
{
    /**
     * @var EmployeeRepository
     */
    private $employees;

    /**
     * PdoCompanyRepository constructor.
     * @param PDOAlias $connection
     * @param EmployeeRepository $employees
     */
    public function __construct(PDOAlias $connection, EmployeeRepository $employees)
    {
        parent::__construct($connection);
        $this->employees = $employees;
    }

    /**
     * @param CompanyId $companyId
     *
     * @return Company
     */
    public function get(CompanyId $companyId): Company
    {
        $result = $this->query('SELECT * FROM companies WHERE id = :id', [':id' => (string)$companyId]);
        $company = array_shift($result);
        $employees = $this->employees->getCompanyEmployees($companyId);
        return CompanyFactory::createFromData($company['id'], $company['name'], $company['domain'], $employees);
    }

    public function persist(Company $company): void
    {
        $result = $this->query(
            'INSERT OR REPLACE INTO companies (id, name, domain) VALUES (:id, :name, :domain);',
            [
                ':id' => (string)$company->getId(),
                ':name' => (string)$company->getName(),
                ':domain' => (string)$company->getDomain(),
            ]
        );
        foreach ($company->getEmployees() as $employee) {
            $this->employees->persist($employee);
        }
    }
}