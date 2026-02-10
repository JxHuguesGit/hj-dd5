<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 */
final class Spell extends Entity
{
    public const FIELDS = [
        Field::NAME,
        Field::SLUG,
        Field::LEVEL,
        Field::SCHOOL,
        Field::CLASSES,
        'content'                ,
        'tempsIncantation'       ,
        'portee'                 ,
        'duree'                  ,
        'composantes'            ,
        'composanteMaterielle'   ,
        'concentration'          ,
        'rituel'                 ,
        'typeAmelioration'       ,
        'ameliorationDescription',
    ];
    public const FIELD_TYPES = [
        Field::NAME              => FieldType::STRING,
        Field::SLUG              => FieldType::STRING,
        Field::LEVEL             => FieldType::STRING,
        Field::SCHOOL            => FieldType::STRING,
        Field::CLASSES           => FieldType::ARRAY,

        'content'                => FieldType::STRING,
        'tempsIncantation'       => FieldType::STRING,
        'portee'                 => FieldType::STRING,
        'duree'                  => FieldType::STRING,
        'composantes'            => FieldType::ARRAY,
        'composanteMaterielle'   => FieldType::STRINGNULLABLE,
        'concentration'          => FieldType::BOOL,
        'rituel'                 => FieldType::BOOL,
        'typeAmelioration'       => FieldType::STRINGNULLABLE,
        'ameliorationDescription'=> FieldType::STRINGNULLABLE,
    ];
    
    public function stringify(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
