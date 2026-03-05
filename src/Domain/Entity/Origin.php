<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
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
        F::ID,
        F::NAME,
        F::FEATID,
        F::TOOLID,
        F::SLUG,
        F::POSTID,
    ];
    public const FIELD_TYPES = [
        F::NAME =>    FieldType::STRING,
        F::FEATID =>  FieldType::INTPOSITIVE,
        F::TOOLID =>  FieldType::INTPOSITIVE,
        F::SLUG =>    FieldType::STRING,
        F::POSTID =>  FieldType::INTPOSITIVE,
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
