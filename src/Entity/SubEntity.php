<?php
namespace src\Entity;

use src\Domain\Entity as DomainEntity;

abstract class SubEntity
{
    protected array $map = [];

    public function __construct(protected DomainEntity $parent) {}

    public function __call(string $name, array $args)
    {
        // getX()
        if (str_starts_with($name, 'get')) {
            $key = lcfirst(substr($name, 3));
            return $this->getMappedField($key);
        }

        // setX(value)
        if (str_starts_with($name, 'set')) {
            $key = lcfirst(substr($name, 3));
            $value = $args[0] ?? null;
            return $this->setMappedField($key, $value);
        }

        throw new \BadMethodCallException("Méthode $name inconnue dans SubEntity.");
    }

    protected function getMappedField(string $key): mixed
    {
        if (!isset($this->map[$key])) {
            throw new \InvalidArgumentException("Clé '$key' inconnue dans la map.");
        }
        return $this->parent->getField($this->map[$key]);
    }

    protected function setMappedField(string $key, mixed $value): self
    {
        if (!isset($this->map[$key])) {
            throw new \InvalidArgumentException("Clé '$key' inconnue dans la map.");
        }
        $this->parent->setField($this->map[$key], $value);
        return $this;
    }
}
