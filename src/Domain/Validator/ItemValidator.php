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
        if ($item->goldPrice>10) {
            $errors[Field::GOLDPRICE] = "Le prix de l'objet est trop élevé, il ne doit pas dépasser 10po.";
        }

        return $errors;
    }
}
