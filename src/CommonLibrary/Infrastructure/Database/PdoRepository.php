<?php


namespace CommonLibrary\Infrastructure\Database;


use PDO as PDOAlias;

class PdoRepository
{
    /**
     * @var PDOAlias
     */
    private $connection;


    /**
     * PdoEmployeeRepository constructor.
     * @param PDOAlias $connection
     */
    public function __construct(PDOAlias $connection)
    {
        $this->connection = $connection;
    }

    protected function query(string $sql, array $params = []): array
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDOAlias::FETCH_ASSOC);
    }
}