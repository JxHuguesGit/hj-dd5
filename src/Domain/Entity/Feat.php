<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property int $featTypeId
 * @property int $postId
 * @property string $slug
 */
final class Feat extends Entity
{
    public const TYPE_ORIGIN = 1;
    public const TYPE_GENERAL = 2;
    public const TYPE_COMBAT = 3;
    public const TYPE_EPIC = 4;

    public const FIELDS = [
        F::ID,
        F::NAME,
        F::FEATTYPEID,
        F::POSTID,
        F::SLUG,
    ];

    public const FIELD_TYPES = [
        F::NAME =>       FieldType::STRING,
        F::FEATTYPEID => FieldType::INTPOSITIVE,
        F::POSTID =>     FieldType::INTPOSITIVE,
        F::SLUG =>       FieldType::STRING,
    ];

    public const EDITABLE_FIELDS = [
        F::FEATTYPEID,
        F::POSTID,
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
            $this->postId,
        );
    }

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
