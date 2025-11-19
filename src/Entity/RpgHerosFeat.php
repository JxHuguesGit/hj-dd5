<?php
namespace src\Entity;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgClasse as RepositoryRpgClasse;
use src\Repository\RpgFeat as RepositoryRpgFeat;

class RpgHerosFeat extends Entity
{

    public function __construct(
        protected int $id,
        protected int $herosId,
        protected int $featId,
        protected int $extra
    ) {

    }

    public function getFeat(): RpgFeat
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
        return $objDao->find($this->{Field::FEATID});
    }

    public function getFullName(): string
    {
        $str = $this->getFeat()->getField(Field::NAME);
        if ($this->extra!=0) {
            $queryBuilder  = new QueryBuilder();
            $queryExecutor = new QueryExecutor();
            $objDao = new RepositoryRpgClasse($queryBuilder, $queryExecutor);
            $rpgClasse = $objDao->find($this->extra);
            $str .= ' ('.$rpgClasse->getField(Field::NAME).')';
        }
        return $str;
    }

}
