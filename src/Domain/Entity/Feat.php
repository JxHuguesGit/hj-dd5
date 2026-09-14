<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property ?string $name
 * @property int $featTypeId
 * @property int $wpPostId
 * @property ?string $slug
 * @property int $sourceId
 * @property ?int $preRequisId
 */
final class Feat extends Entity
{
    public const TYPE_ORIGIN = 1;
    public const TYPE_GENERAL = 2;
    public const TYPE_COMBAT = 3;
    public const TYPE_EPIC = 4;

    public const FIELDS = [
        F::ID,
        F::FEATTYPEID,
        F::WPPOSTID,
        F::SOURCEID,
        F::PREREQUISID,
    ];

    public const RELATION_FIELDS = [
        F::NAME,
        F::SLUG,
    ];

    public const FIELD_TYPES = [
        F::FEATTYPEID => FieldType::INTPOSITIVE,
        F::WPPOSTID   => FieldType::INTNULLABLE,
        F::SOURCEID   => FieldType::INTPOSITIVE,
        F::PREREQUISID => FieldType::INTNULLABLE,

        F::NAME       => FieldType::STRINGNULLABLE,
        F::SLUG       => FieldType::STRINGNULLABLE,
    ];

    public const EDITABLE_FIELDS = [
        F::FEATTYPEID,
        F::WPPOSTID,
        F::SOURCEID,
        F::PREREQUISID,
    ];

    /**
     * Retourne une représentation texte du don
     */
    public function stringify(): string
    {
        return sprintf(
            "%s - Slug : %s - (FeatType: %s, PostID: %d)",
            $this->name,
            $this->getSlug(),
            $this->featTypeId,
            $this->wpPostId,
        );
    }

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
