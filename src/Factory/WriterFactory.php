<?php
namespace src\Factory;

use src\Factory\RepositoryFactory;

final class WriterFactory
{
    private array $cache = [];

    public function __construct(
        private RepositoryFactory $repositories
    ) {}

    public function __call(string $name, array $args): object
    {
        if (!isset($this->cache[$name])) {
            $this->cache[$name] = $this->make($name);
        }

        return $this->cache[$name];
    }

    private function make(string $name): object
    {
        $class = 'src\\Service\\Writer\\'
            . ucfirst($name)
            . 'Writer';

        if (!class_exists($class)) {
            throw new \BadMethodCallException(
                "Writer inconnu : '$name'"
            );
        }

        return new $class(
            $this->repositories->$name()
        );
    }
}
