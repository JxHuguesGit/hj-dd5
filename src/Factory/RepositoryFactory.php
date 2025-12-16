<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Repository;

class RepositoryFactory
{
    public static function create(string $repositoryClass): Repository
    {
        return new $repositoryClass(
            new QueryBuilder(),
            new QueryExecutor()
        );
    }
}
