<?php

namespace Manager;

abstract class AbstractManager
{
    /** @var \PDO */
    protected $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
}
