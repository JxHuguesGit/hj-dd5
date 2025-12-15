<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * Classe de base pour toutes les entités Domain.
 *
 * @property-read int|null $id
 * @method string stringify() Retourne une représentation textuelle de l'entité
 */
abstract class Entity
{
    //////////////////////////////////////////////////////////
    // Attributs
    protected ?int $id = null;
    /** Stockage interne des données des champs */
    protected array $data = [];
    /** Champs de l’entité */
    public const FIELDS = [];
    /** Types des champs, associés aux constantes FieldType */
    public const FIELD_TYPES = [];
    /** Cache pour la validation des schémas */
    protected static array $validatedSchemas = [];
    //////////////////////////////////////////////////////////

    /**
     * Constructeur générique : hydrate l’entité depuis un tableau associatif.
     */
    public function __construct(array $attributes = [])
    {
        static::validateSchema();

        foreach ($attributes as $field => $value) {
            if ($field===Field::ID) {
                $this->assignId($value);
            } else {
                $this->__set($field, $value);
            }
        }
    }

    /**
     * Magic getter pour accéder aux champs via $entity->field
     */
    public function __get(string $name)
    {
        if ($name===Field::ID) {
            return $this->id;
        }

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        throw new \InvalidArgumentException("Propriété '$name' inconnue dans " . static::class);
    }

    /**
     * Magic setter pour valider et stocker les champs via $entity->field = value
     */
    public function __set(string $name, mixed $value): void
    {
        if (!in_array($name, static::FIELDS, true)) {
            throw new \InvalidArgumentException("Propriété '$name' inconnue dans " . static::class);
        }

        if (method_exists($this, 'validateField')) {
            $value = $this->validateField($name, $value);
        }

        $this->data[$name] = $value;
    }

    /**
     * Hydrate l’ID une seule fois
     */
    final public function assignId(int $id): self
    {
        if ($this->id !== null) {
            throw new \LogicException("L'ID est déjà défini pour " . static::class);
        }
        $this->id = $id;
        return $this;
    }

    /**
     * Retourne toutes les données sous forme de tableau
     */
    public function toArray(): array
    {
        return array_merge([Field::ID=>$this->id], $this->data);
    }

    /**
     * Validation statique du schema : FIELDS et FIELD_TYPES cohérents
     */
    protected static function validateSchema(): void
    {
        $class = static::class;
        if (isset(static::$validatedSchemas[$class])) {
            return;
        }

        if (count(static::FIELDS) !== count(array_unique(static::FIELDS))) {
            throw new \LogicException("Doublons détectés dans FIELDS de $class");
        }

        foreach (static::FIELDS as $field) {
            if ($field===Field::ID) {
                continue;
            }
            if (!array_key_exists($field, static::FIELD_TYPES)) {
                throw new \LogicException("Le champ '$field' doit avoir un type défini dans FIELD_TYPES pour $class");
            }
        }

        static::$validatedSchemas[$class] = true;
    }

    /**
     * Optionnel : méthode simple pour afficher l’entité
     */
    public function __toString(): string
    {
        if (method_exists($this, 'stringify')) {
            return $this->stringify();
        }

        return implode(' - ', array_map(
            fn($field) => (string)($this->__get($field) ?? 'Non défini'),
            static::FIELDS
        ));
    }

    /**
     * Méthode générique de validation des champs (à redéfinir dans les entités filles si nécessaire)
     */
    protected function validateField(string $field, mixed $value): mixed
    {
        $types = static::FIELD_TYPES;
        $expectedType = $types[$field] ?? null;

        if (!$expectedType) {
            return $value;
        }

        return match ($expectedType) {
            FieldType::INT => $this->validateInt($field, $value),
            FieldType::INTPOSITIVE  => $this->validateIntPositive($field, $value),
            FieldType::FLOAT => $this->validateFloat($field, $value),
            FieldType::BOOL => $this->validateBool($field, $value),
            FieldType::STRING => $this->validateString($field, $value),
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
        $value = $this->validateInt($field, $value);
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

}
