<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property int $parentId
 * @property int $postId
 */
final class Specie extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SLUG,
        Field::PARENTID,
        Field::POSTID,
    ];
    public const FIELD_TYPES = [
        Field::NAME =>     FieldType::STRING,
        Field::SLUG =>     FieldType::STRING,
        Field::PARENTID => FieldType::INTPOSITIVE,
        Field::POSTID =>   FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte de l'historique
     */
    public function stringify(): string
    {
        return sprintf(
            "%s - Slug : %s - ParentId : %s - PostId : %s",
            $this->name,
            $this->getSlug(),
            $this->parentId,
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
