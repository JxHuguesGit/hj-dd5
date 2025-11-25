<?php
namespace src\Entity;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class Entity
{
    private static array $validatedSchemas = [];

    protected ?int $id = null;

    protected static QueryBuilder $qb;
    protected static QueryExecutor $qe;

    public const DISPLAY_FIELDS = [];
    public const FIELDS = [];
    public const FIELD_TYPES = [];
    public const TABLE  = null;

    public function __construct(array $attributes = [])
    {
        $class = static::class;

        if (!isset(self::$validatedSchemas[$class])) {
            static::validateSchema();
            self::$validatedSchemas[$class] = true;
        }

        // Hydratation habituelle
        foreach ($attributes as $key => $value) {
            if ($key === 'id') {
                $this->assignId($value);
                continue;
            }
            if (property_exists($this, $key)) {
                $this->setField($key, $value);
            }
        }
    }

    public function __call(string $name, array $args)
    {
        if (strpos($name, 'get') === 0) {
            $field = lcfirst(substr($name, 3));
            return $this->getField($field);
        }

        if (strpos($name, 'set') === 0) {
            $field = lcfirst(substr($name, 3));
            return $this->setField($field, $args[0] ?? null);
        }

        throw new \BadMethodCallException("Méthode $name inconnue.");
    }

    public function __toString(): string
    {
        if (method_exists($this, 'stringify')) {
            return $this->stringify();
        }

        $fields = !empty(static::DISPLAY_FIELDS) ? static::DISPLAY_FIELDS : static::FIELDS;

        $parts = [];
        foreach ($fields as $field) {
            $parts[] = (string) ($this->getFieldSafe($field) ?? 'Non défini');
        }

        return implode(' - ', $parts);
    }

    protected function getFieldSafe(string $field): mixed
    {
        return property_exists($this, $field) ? $this->{$field} : null;
    }

    public function toArray(): array
    {
        $array = ['id'=>$this->id];

        foreach (static::getFields() as $field) {
            $array[$field] = $this->getFieldSafe($field) ?? null;
        }

        return $array;
    }
    
    public static function getFields(): array
    {
        return static::FIELDS;
    }
    
    public function getField(string $field): mixed
    {
        if (!property_exists($this, $field)) {
            throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
        }
        return $this->{$field};
    }

    public function setField(string $field, mixed $value): self
    {
        if ($field === 'id') {
            throw new \LogicException("Impossible de modifier l'identifiant d'une entité.");
        }

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

    public function assignId(int $id): self
    {
        if ($this->id !== null) {
            throw new \LogicException("L'identifiant est déjà défini et ne peut plus être modifié.");
        }

        $this->id = $id;
        return $this;
    }

    protected function getRelatedEntity(
        string $cacheProperty,
        string $repositoryClass,
        int $id
    ): ?object {
        if ($this->{$cacheProperty} === null) {
            $repo = new $repositoryClass(static::$qb, static::$qe);
            $this->{$cacheProperty} = $repo->find($id);
        }
        return $this->{$cacheProperty};
    }

    protected function validateField(string $field, mixed $value): mixed
    {
        $types = static::FIELD_TYPES ?? [];
        $expectedType = $types[$field] ?? null;

        if (!$expectedType) {
            // Aucun type défini, on accepte la valeur telle quelle
            return $value;
        }

        return match($expectedType) {
            'int' => $this->validateInt($field, $value),
            'intPositive' => $this->validateIntPositive($field, $value),
            'float' => $this->validateFloat($field, $value),
            'bool' => $this->validateBool($field, $value),
            'string' => $this->validateString($field, $value),
            default => $value,
        };
    }

    protected function validateInt(string $field, mixed $value): int
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Le champ '$field' doit être un entier.");
        }
        return (int)$value;
    }

    protected function validateIntPositive(string $field, mixed $value): int
    {
        $value = (int)$value;
        if ($value < 0) {
            throw new \InvalidArgumentException("Le champ '$field' doit être strictement positif.");
        }
        return $value;
    }

    protected function validateFloat(string $field, mixed $value): float
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Le champ '$field' doit être un nombre.");
        }
        return (float)$value;
    }

    protected function validateBool(string $field, mixed $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($result === null) {
            throw new \InvalidArgumentException("Le champ '$field' doit être un booléen.");
        }
        return $result;
    }

    protected function validateString(string $field, mixed $value): string
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("Le champ '$field' doit être une chaîne.");
        }
        return trim($value);
    }

    public static function validateSchema(): void {
        if (count(static::FIELDS) !== count(array_unique(static::FIELDS))) {
            throw new \LogicException("Doublons détectés dans FIELDS.");
        }

        foreach (static::FIELDS as $field) {
            if (!property_exists(static::class, $field)) {
                throw new \LogicException("Le champ '$field' est déclaré dans FIELDS mais n'existe pas dans la classe.");
            }
        }
    }

    public static function setSharedDependencies(QueryBuilder $qb, QueryExecutor $qe): void
    {
        static::$qb = $qb;
        static::$qe = $qe;
    }
}
