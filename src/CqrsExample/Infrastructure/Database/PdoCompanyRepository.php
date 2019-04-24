<?php


namespace CqrsExample\Infrastructure\Database;


use CommonLibrary\Infrastructure\Database\PdoRepository;
use CqrsExample\Domain\Company;
use CqrsExample\Domain\Company\CompanyId;
use CqrsExample\Domain\Company\CompanyFactory;
use CqrsExample\Domain\Company\CompanyRepository;
use CqrsExample\Domain\Employee\EmployeeRepository;
use PDO;

class PdoCompanyRepository extends PdoRepository implements CompanyRepository
{
    /**
     * @var EmployeeRepository
     */
    private $employees;

    /**
     * PdoCompanyRepository constructor.
     * @param PDO $connection
     * @param EmployeeRepository $employees
     */
    public function __construct(PDO $connection, EmployeeRepository $employees)
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
        $r = $this->query('SELECT * FROM companies WHERE id = :id', [':id' => (string)$companyId]);
        $employees = $this->employees->getCompanyEmployees($companyId);
        return CompanyFactory::createFromData($r['id'], $r['name'], $r['domain'], $employees);
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