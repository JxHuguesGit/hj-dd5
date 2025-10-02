<?php
namespace src\Entity;

class Entity
{
    protected int $id;
    protected array $fields = [];

    public function __construct(array $attributes = [])
    {
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function __toString(): string
    {
        $fields = static::getFields();
        $str = '';
        foreach ($fields as $field) {
            $str .= ($this->{$field} ?? 'Non défini') . ' - ';
        }
        return rtrim($str, ' - ') . '<br>';
    }

    public function initRepository(array $repositories = []): void
    {
        foreach ($repositories as $repository) {
            if (class_exists($repository)) {
                $this->{$repository} = new $repository;
            }
        }
    }

    public function getField(string $field)
    {
        if (property_exists($this, $field)) {
            return $this->{$field};
        }
        throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
    }

    public function setField(string $field, $value): void
    {
        if (property_exists($this, $field)) {
            // Logique de validation de la valeur si nécessaire
            $this->{$field} = $value === null ? ' ' : $value;
        } else {
            throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
        }
    }

    public static function getFields(): array
    {
        return [];
    }

    public function getFieldValues(array $fields=[]): array
    {
        $values = [];
        if (!empty($fields)) {
            foreach ($fields as $field) {
                $values[] = $this->{$field};
            }
        }
        return $values;
    }
}
