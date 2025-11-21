<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgFeat as ControllerRpgFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
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

    protected string $name;
    protected int $featTypeId;
    protected int $postId;

    public function getController(): ControllerRpgFeat
    {
        $controller = new ControllerRpgFeat;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }
    
    public function getFeatType(): ?RpgFeatType
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeatType($queryBuilder, $queryExecutor);
        return $objDao->find($this->featTypeId);
    }
    
    public function getWpPost(): ?WP_Post
    {
        return get_post($this->postId);
    }
}
