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

    public function stringify(): string
    {
        return sprintf(
            "[%s] %s",
            $this->getId(),
            $this->getName()
        );
    }

    public function getController(): ControllerRpgFeat
    {
        $controller = new ControllerRpgFeat;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }
    
    public function getFeatType(): ?RpgFeatType
    {
        $objDao = new RepositoryRpgFeatType($this->qb, $this->qe);
        return $objDao->find($this->featTypeId);
    }
    
    public function getWpPost(): ?WP_Post
    {
        return get_post($this->postId);
    }
}
