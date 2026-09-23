<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property int $id
 * @property ?int $wpPostId
 * @property int $sourceId
 * @property int $schoolId
 * @property int $castingTimeId
 * @property int $rangeId
 * @property int $durationId
 * @property ?int $spellEnhancementId
 * @property ?int $spellTriggerId
 * @property ?int $materialComponentId
 * @property int $level
 * @property bool $rituel
 * @property bool $concentration
 * @property string $components
 *
 * @property ?string $name
 * @property ?string $slug
 * @property ?string $description
 */
final class Spell extends Entity
{
    public const FIELDS = [
        F::ID,
        F::WPPOSTID,
        F::SOURCEID,
        F::SCHOOLID,
        F::CASTINGTIMEID,
        F::RANGEID,
        F::DURATIONID,
        F::SPELLENHANCEMENTID,
        F::SPELLTRIGGERID,
        F::MATERIALCOMPID,
        F::LEVEL,
        F::RITUEL,
        F::CONCENTRATION,
        F::COMPONENTS,
    ];

    public const RELATION_FIELDS = [
        F::NAME,
        F::SLUG,
        F::DESCRIPTION,
        F::SCHOOLNAME,
        F::RANGENAME,
        F::DURATIONNAME,
        F::CASTINGTIMENAME,
        F::MATERIALCOMPNAME,
        F::SOURCENAME,
        F::SOURCECODE,

        F::CLASSES,
    ];

    public const FIELD_TYPES = [
        F::ID                    => FieldType::INTPOSITIVE,
        F::WPPOSTID              => FieldType::INTNULLABLE,
        F::SOURCEID              => FieldType::INTPOSITIVE,
        F::SCHOOLID              => FieldType::INTPOSITIVE,
        F::CASTINGTIMEID         => FieldType::INTPOSITIVE,
        F::RANGEID               => FieldType::INTPOSITIVE,
        F::DURATIONID            => FieldType::INTPOSITIVE,
        F::SPELLENHANCEMENTID    => FieldType::INTNULLABLE,
        F::SPELLTRIGGERID        => FieldType::INTNULLABLE,
        F::MATERIALCOMPID        => FieldType::INTNULLABLE,
        F::LEVEL                  => FieldType::INTPOSITIVE,
        F::RITUEL                 => FieldType::BOOL,
        F::CONCENTRATION          => FieldType::BOOL,
        F::COMPONENTS             => FieldType::STRING,

        F::NAME                   => FieldType::STRINGNULLABLE,
        F::SLUG                   => FieldType::STRINGNULLABLE,
        F::DESCRIPTION            => FieldType::STRINGNULLABLE,
        F::SCHOOLNAME             => FieldType::STRING,
        F::RANGENAME              => FieldType::STRING,
        F::DURATIONNAME           => FieldType::STRING,
        F::CASTINGTIMENAME        => FieldType::STRING,
        F::MATERIALCOMPNAME       => FieldType::STRINGNULLABLE,
        F::SOURCENAME             => FieldType::STRING,
        F::SOURCECODE             => FieldType::STRING,

        F::CLASSES                => FieldType::ARRAY,
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
