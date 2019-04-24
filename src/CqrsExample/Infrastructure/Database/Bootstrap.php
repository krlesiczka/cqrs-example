<?php
namespace CqrsExample\Infrastructure\Database;


use CommonLibrary\Infrastructure\Database\PdoRepository;

class Bootstrap extends PdoRepository
{
    public function run(): void
    {
        $this->query('
          CREATE TABLE IF NOT EXISTS companies (id TEXT PRIMARY KEY, name TEXT, domain TEXT);
        ');

        $this->query('
          CREATE TABLE IF NOT EXISTS employees (email TEXT PRIMARY KEY, name TEXT, phone TEXT, companyId TEXT);
        ');

        $this->query('
          CREATE TABLE IF NOT EXISTS companies_view (email TEXT PRIMARY KEY, name TEXT, phone TEXT, employeesCount INT);
        ');

        $this->query(
            'INSERT OR REPLACE INTO companies (id, name, domain) VALUES (:id, :name, :domain);',
            [
                ':id' => '1d1b947f-c89b-49c7-8358-f3ffc457de59',
                ':name' => 'TEST COMPANY',
                ':domain' => 'test.domain',
            ]
        );

        $this->query(
            'INSERT OR REPLACE INTO companies_view (id, name, domain, employeesCount) VALUES (:id, :name, :domain :count);',
            [
                ':id' => '1d1b947f-c89b-49c7-8358-f3ffc457de59',
                ':name' => 'TEST COMPANY',
                ':domain' => 'test.domain',
                ':count' => 0,
            ]
        );
    }
}