<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

final class Monster extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::FRNAME,
        Field::NAME,
        Field::FRTAG,
        Field::UKTAG,
        Field::INCOMPLET,
        Field::SCORECR,
        Field::MSTTYPEID,
        Field::MSTSSTYPID,
        Field::SWARMSIZE,
        Field::SCORECA,
        Field::SCOREHP,
        Field::REFID,
    ];
    public const FIELD_TYPES = [
        Field::FRNAME     => FieldType::STRING,
        Field::NAME       => FieldType::STRING,
        Field::FRTAG      => FieldType::STRING,
        Field::UKTAG      => FieldType::STRING,
        Field::INCOMPLET  => FieldType::INTNULLABLE,
        Field::SCORECR    => FieldType::FLOAT,
        Field::MSTTYPEID  => FieldType::INT,
        Field::MSTSSTYPID => FieldType::INTNULLABLE,
        Field::SWARMSIZE  => FieldType::INTNULLABLE,
        Field::SCORECA    => FieldType::INT,
        Field::SCOREHP    => FieldType::INT,
        Field::REFID      => FieldType::INT,
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

    public function isComplete(): bool
    {
        return $this->incomplet==0;
    }
}
