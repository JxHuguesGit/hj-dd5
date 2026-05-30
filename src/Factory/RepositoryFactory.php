<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RepositoryFactory
{
    private array $cache = [];

    public function __construct(
        private QueryBuilder $builder,
        private QueryExecutor $executor
    ) {}

    public function __call(string $name, array $args): object
    {
        if (! isset($this->cache[$name])) {
            $this->cache[$name] = $this->make($name);
        }

        return $this->cache[$name];
    }

    private function make(string $name): object
    {
        $class = 'src\\Repository\\'
            . ucfirst($name)
            . 'Repository';

        if (! class_exists($class)) {
            throw new \BadMethodCallException(
                "Repository inconnu : '$name'"
            );
        }

        return new $class(
            $this->builder,
            $this->executor
        );
    }
}
