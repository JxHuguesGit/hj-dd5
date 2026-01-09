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
