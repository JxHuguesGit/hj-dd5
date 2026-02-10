<?php
namespace src\Domain\Validator;

use src\Constant\Field;
use src\Domain\Item;
use src\Constant\FieldType;

final class ItemValidator
{
    public static function validate(Item $item): array
    {
        $errors = GenericValidator::validate($item, Item::FIELD_TYPES);
        
        if ($item->type!='other') {
            $errors[Field::TYPE] = "Le type de l'objet doit être <strong>other</strong>.";
        }
        if (mb_strlen($item->name)>40) {
            $errors[Field::NAME] = "Le nom de l'objet ne doit pas dépasser 40 caractères.";
        }

        return $errors;
    }
}
