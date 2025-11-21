<?php
namespace src\Entity;

class Entity
{
    public const TABLE  = null;
    public const FIELDS = [];
    protected int $id;

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
        $parts = [];

        foreach ($fields as $field) {
            $parts[] = (string) ($this->{$field} ?? 'Non défini');
        }

        return implode(' - ', $parts);
    }
    
    public function toArray(): array
    {
        $array = [];

        foreach (static::getFields() as $field) {
            $array[$field] = $this->$field ?? null;
        }

        return $array;
    }
    
    public static function getFields(): array
    {
        return static::FIELDS ?? [];
    }
    
    public function getField(string $field)
    {
        if (!property_exists($this, $field)) {
            throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
        }
        return $this->{$field};
    }

    public function setField(string $field, mixed $value): self
    {
        if (!property_exists($this, $field)) {
            throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
        }

        // Hook pour validations personnalisées dans les entités enfants
        if (method_exists($this, 'validateField')) {
            $value = $this->validateField($field, $value);
        }

        $this->{$field} = $value;

        return $this;
    }

    protected function validateField(string $field, $value)
    {
        return $value;
    }
}
