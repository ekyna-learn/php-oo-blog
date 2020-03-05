<?php

namespace Repository;

use PDO;

abstract class AbstractRepository
{
    /** @var PDO */
    protected $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
}
