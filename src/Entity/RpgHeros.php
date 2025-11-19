<?php
namespace src\Entity;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Repository\RpgHerosFeat as RepositoryRpgHeroFeat;
use src\Utils\Session;

class RpgHeros extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $originId,
        protected int $speciesId,
        protected int $wpUserId,
        protected string $createStep,
        protected int $lastUpdate
    ) {

    }

    public static function init()
    {
        return new self(...[0, '', 0, 0, Session::getWpUser()->data->ID, 'name', time()]);
    }

    public function getOrigin(): ?RpgOrigin
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoOrigins = new RepositoryRpgOrigin($queryBuilder, $queryExecutor);
        return $objDaoOrigins->find($this->{Field::ORIGINID});
    }

    public function getStrClasses(): string
    {
        return '';
    }

    public function getSpecies(): ?RpgSpecies
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoSpecies = new RepositoryRpgSpecies($queryBuilder, $queryExecutor);
        return $objDaoSpecies->find($this->{Field::SPECIESID});
    }

    public function getOriginFeat(bool $extra=false): RpgFeat
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgHeroFeat($queryBuilder, $queryExecutor);

        $objHerosFeat = $objDao->findOriginFeat([Field::HEROSID=>$this->{Field::ID}], [Field::ID=>($extra?Constant::CST_DESC:Constant::CST_ASC)]);
        if ($objHerosFeat==null || $objHerosFeat->getField(Field::ID)==0) {
            // On est dans le cas où on arrive pour la première fois sur l'écran.
            // Il faut reprendre le feat associé à l'origine.
            return $this->getOrigin()->getOriginFeat();
        }
        return $objHerosFeat->getFeat();
    }
}
