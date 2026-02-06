<?php
namespace src\Factory;

use src\Constant\FieldType;
use src\Domain\Entity;

class EntityFactory
{

    public static function createEmpty(string $entityClass): Entity
    {
        $defaults = [];
        foreach ($entityClass::FIELD_TYPES as $field=>$type) {
            switch ($type) {
                case FieldType::STRING :
                    $defaults[$field] = '';
                    break;
                case FieldType::FLOAT :
                    $defaults[$field] = 0.0;
                    break;
                case FieldType::INTPOSITIVE :
                    $defaults[$field] = 0;
                    break;
                default :
                    $defaults[$field] = null;
                    break;
            }
        }
        return new $entityClass($defaults);
    }
}
