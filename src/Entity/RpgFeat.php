<?php
namespace src\Entity;

use src\Controller\RpgFeat as ControllerRpgFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeatType as RepositoryRpgFeatType;
use WP_Post;

class RpgFeat extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $featTypeId,
        protected int $postId
    ) {

    }

    public function getController(): ControllerRpgFeat
    {
        $controller = new ControllerRpgFeat;
        $controller->setField('rpgFeat', $this);
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
