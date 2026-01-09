<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Utils\Utils;

/**
 * @property string $name
 * @property int $featId
 * @property int $toolId
 * @property string $slug
 * @property int $postId
 */
final class Origin extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::FEATID,
        Field::TOOLID,
        Field::SLUG,
        Field::POSTID,
    ];
    public const FIELD_TYPES = [
        Field::NAME =>    FieldType::STRING,
        Field::FEATID =>  FieldType::INTPOSITIVE,
        Field::TOOLID =>  FieldType::INTPOSITIVE,
        Field::SLUG =>    FieldType::STRING,
        Field::POSTID =>  FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte de l'historique
     */
    public function stringify(): string
    {
        return sprintf(
            "%s - Slug : %s - FeatId : %s - ToolId : %s - PostId : %s",
            $this->name,
            $this->getSlug(),
            $this->featId,
            $this->tooldId,
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
