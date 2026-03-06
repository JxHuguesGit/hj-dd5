<?php
namespace src\Domain\Entity;

use src\Constant\Constant as C;
use src\Constant\Field as F;
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
        F::NAME,
        F::SLUG,
        F::NIVEAU,
        F::SCHOOL,
        F::CLASSES,
        C::CONTENT,
        'tempsIncantation',
        'portee',
        'duree',
        'composantes',
        'composanteMaterielle',
        'concentration',
        'rituel',
        'typeAmelioration',
        'ameliorationDescription',
    ];
    public const FIELD_TYPES = [
        F::NAME               => FieldType::STRING,
        F::SLUG               => FieldType::STRING,
        F::NIVEAU              => FieldType::STRING,
        F::SCHOOL             => FieldType::STRING,
        F::CLASSES            => FieldType::ARRAY,

        C::CONTENT     => FieldType::STRING,
        'tempsIncantation'        => FieldType::STRING,
        'portee'                  => FieldType::STRING,
        'duree'                   => FieldType::STRING,
        'composantes'             => FieldType::ARRAY,
        'composanteMaterielle'    => FieldType::STRINGNULLABLE,
        'concentration'           => FieldType::BOOL,
        'rituel'                  => FieldType::BOOL,
        'typeAmelioration'        => FieldType::STRINGNULLABLE,
        'ameliorationDescription' => FieldType::STRINGNULLABLE,
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
