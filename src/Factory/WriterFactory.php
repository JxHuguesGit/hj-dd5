<?php
namespace src\Factory;

use src\Constant\Constant as C;
use src\Factory\RepositoryFactory;

final class WriterFactory
{
    private array $cache = [];

    private const MAP = [
        C::MAP                    => [C::WRITER => 'MapWriter',                   C::REPO => C::MAP],
        C::MAPTOKEN               => [C::WRITER => 'MapTokenWriter',              C::REPO => C::MAPTOKEN],
        C::TOKEN                  => [C::WRITER => 'TokenWriter',                 C::REPO => C::TOKEN],
    ];

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
        $config = self::MAP[$name]
            ?? throw new \BadMethodCallException("Writer inconnu : '$name'.");

        $writerClass = 'src\\Service\\Writer\\' . $config[C::WRITER];
        $repository  = $config[C::REPO];

        return new $writerClass(
            $this->repositories->$repository()
        );
    }
}
