<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgFeat as ControllerRpgFeat;
use src\Repository\RpgFeatType as RepositoryRpgFeatType;
use WP_Post;

class RpgFeat extends Entity
{
    public const TABLE = 'rpgFeat';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::FEATTYPEID,
        Field::POSTID,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::FEATTYPEID => 'intPositive',
        Field::POSTID => 'intPositive',
    ];

    protected string $name    = '';
    protected int $featTypeId = 0;
    protected int $postId     = 0;

    private ?WP_Post $wpPostCache = null;

    public function stringify(): string
    {
        return sprintf(
            "%s (Type: %s, PostID: %d)",
            $this->getName(),
            $this->getFeatType()?->getName() ?? 'N/A',
            $this->postId
        );
    }

    // TODO : Externaliser
    public function getController(): ControllerRpgFeat
    {
        $controller = new ControllerRpgFeat;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getFeatType(): ?RpgFeatType
    {
        return $this->getRelatedEntity('featTypeCache', RepositoryRpgFeatType::class, $this->featTypeId);
    }
    
    public function getWpPost(): ?WP_Post
    {
        if ($this->wpPostCache === null) {
            $this->wpPostCache = get_post($this->postId) ?: null;
        }
        return $this->wpPostCache;
    }
}
