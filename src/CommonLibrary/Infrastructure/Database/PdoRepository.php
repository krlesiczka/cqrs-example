<?php


namespace CommonLibrary\Infrastructure\Database;


use PDO;

class PdoRepository
{
    /**
     * @var PDO
     */
    private $connection;


    /**
     * PdoEmployeeRepository constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    protected function query($sql, $params)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}