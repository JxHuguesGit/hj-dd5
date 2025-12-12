<?php
namespace src\Action;

use src\Entity\Entity;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;

class LoadCreationStepSide
{
    public static function build(string $type, int $id): string
    {
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());

    switch ($type) {
        case 'origin' :
            $obj = new RepositoryRpgOrigin(Entity::$qb, Entity::$qe);
            $origin = $obj->find($id);
            $returned = $origin->getController()->getDescription();
           break;
        case 'feat' :
            $obj = new RepositoryRpgFeat(Entity::$qb, Entity::$qe);
            $origin = $obj->find($id);
            $returned = $origin->getController()->getDescription();
           break;
            default :
            $returned = '';
            break;
        }
        return $returned;
    }

}
