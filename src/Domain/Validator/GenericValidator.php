<?php
namespace src\Domain\Validator;

use src\Constant\FieldType;
use src\Domain\Entity;

final class GenericValidator
{
    public static function validate(Entity $entity, array $fieldTypes): array
    {
        $errors = [];

        foreach ($fieldTypes as $field => $type) {
            $value = $entity->$field ?? null;

            switch ($type) {
                case FieldType::STRING:
                    if (!is_string($value) || trim($value) === '') {
                        $errors[$field] = "Le champ $field doit être une chaîne non vide.";
                    }
                    break;

                case FieldType::FLOAT:
                    if (!is_numeric($value)) {
                        $errors[$field] = "Le champ $field doit être un nombre.";
                    }
                    break;

                case FieldType::INTPOSITIVE:
                    if (!is_numeric($value) || (int)$value < 0) {
                        $errors[$field] = "Le champ $field doit être un entier positif.";
                    }
                    break;
                default:
                    $errors[$field] = "Le type de champ $field ($type) n'est pas supporté.";
                    break;
            }
        }

        return $errors;
    }
}
