<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
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
        Field::ID,
        Field::NAME,
        Field::FEATTYPEID,
        Field::POSTID,
        Field::SLUG,
    ];

    public const FIELD_TYPES = [
        Field::NAME =>       FieldType::STRING,
        Field::FEATTYPEID => FieldType::INTPOSITIVE,
        Field::POSTID =>     FieldType::INTPOSITIVE,
        Field::SLUG =>       FieldType::STRING,
    ];

    public const EDITABLE_FIELDS = [
        Field::FEATTYPEID,
        Field::POSTID,
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
