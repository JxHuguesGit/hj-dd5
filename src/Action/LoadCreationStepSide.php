<?php
namespace src\Action;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;

class LoadCreationStepSide
{
    public static function build(string $type, int $id): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
    
    switch ($type) {
        case 'origin' :
            $obj = new RepositoryRpgOrigin($queryBuilder, $queryExecutor);
            $origin = $obj->find($id);
            $returned = $origin->getController()->getDescription();
           break;
        case 'feat' :
            $obj = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
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
