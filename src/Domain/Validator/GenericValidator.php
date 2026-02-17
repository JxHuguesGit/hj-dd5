<?php
namespace src\Domain\Validator;

use src\Constant\FieldType;
use src\Domain\Entity;

final class GenericValidator
{
    private static array $rules = [
        FieldType::STRING => 'validateString',
        FieldType::FLOAT => 'validateFloat',
        FieldType::INTPOSITIVE => 'validateIntPositive',
        FieldType::ARRAY => 'validateArray',
        FieldType::BOOL => 'validateBool',
        FieldType::INT => 'validateInt',
        FieldType::INTNULLABLE => 'validateIntNullable',
        FieldType::STRINGNULLABLE => 'validateStringNullable',
    ];

    public static function validate(Entity $entity, array $fieldTypes): array {
        $errors = [];
        foreach ($fieldTypes as $field => $type) {
            $value = $entity->$field ?? null;
            if (!isset(self::$rules[$type])) {
                $errors[$field] = "Le type de champ $field ($type) n'est pas supporté.";
                continue;
            }
            $method = self::$rules[$type];
            $error = self::$method($field, $value);
            if ($error !== null) {
                $errors[$field] = $error;
            }
        }
        return $errors;
    }

    private static function validateString(string $field, $value): ?string {
        return (!is_string($value) || trim($value) === '') ? "Le champ $field doit être une chaîne non vide." : null;
    }
    private static function validateFloat(string $field, $value): ?string {
        return (!is_numeric($value)) ? "Le champ $field doit être un nombre." : null;
    }
    private static function validateIntPositive(string $field, $value): ?string {
        return (!is_numeric($value) || (int)$value < 0) ? "Le champ $field doit être un entier positif." : null;
    }
    private static function validateArray(string $field, $value): ?string {
        return (!is_array($value)) ? "Le champ $field doit être un tableau." : null;
    }
    private static function validateBool(string $field, $value): ?string {
        return (!is_bool($value)) ? "Le champ $field doit être un booléen." : null;
    }
    private static function validateInt(string $field, $value): ?string {
        return (!is_int($value)) ? "Le champ $field doit être un entier." : null;
    }
    private static function validateIntNullable(string $field, $value): ?string {
        return ($value !== null && !is_int($value)) ? "Le champ $field doit être un entier ou null." : null;
    }
    private static function validateStringNullable(string $field, $value): ?string {
        return ($value !== null && !is_string($value)) ? "Le champ $field doit être une chaîne ou null." : null;
    }
}

