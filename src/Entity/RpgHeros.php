<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgHerosFeat as RepositoryRpgHerosFeat;
use src\Repository\RpgHerosSkill as RepositoryRpgHerosSkill;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Utils\Session;

class RpgHeros extends Entity
{
    public const TABLE = 'rpgHeros';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::ORIGINID,
        Field::SPECIESID,
        Field::WPUSERID,
        Field::CREATESTEP,
        Field::LASTUPDATE,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::ORIGINID => 'intPositive',
        Field::SPECIESID => 'intPositive',
        Field::WPUSERID => 'intPositive',
        Field::CREATESTEP => 'string',
        Field::LASTUPDATE => 'intPositive',
    ];

    protected string $name = '';
    protected int $originId = 0;
    protected int $speciesId = 0;
    protected int $wpUserId = 0;
    protected string $createStep = '';
    protected int $lastUpdate = 0;

    private ?RpgFeat $originFeatCache = null;

    public static function init()
    {
        return new self([
            'id' => 0,
            'name' => '',
            'originId' => 0,
            'speciesId' => 0,
            'wpUserId' => Session::getWpUser()->data->ID,
            'createStep' => 'name',
            'lastUpdate' => time(),
        ]);
    }

    public function stringify(): string
    {
        $origin = $this->getOrigin()?->getName() ?? '??';
        $species = $this->getSpecies()?->getName() ?? '??';
        return sprintf("%s (%s, %s)", $this->getName(), $origin, $species);
    }

    // TODO
    public function getStrClasses(): string
    {
        return '';
    }
    
    public function getOrigin(): ?RpgOrigin
    {
        return $this->getRelatedEntity('originCache', RepositoryRpgOrigin::class, $this->originId);
    }

    public function getSpecies(): ?RpgSpecies
    {
        return $this->getRelatedEntity('speciesCache', RepositoryRpgSpecies::class, $this->speciesId);
    }

    public function getOriginFeat(bool $extra=false): RpgFeat
    {
        if ($this->originFeatCache === null) {
            $objDao = new RepositoryRpgHerosFeat(static::$qb, static::$qe);
            $objHerosFeat = $objDao->findOriginFeat(
                [Field::HEROSID => $this->id],
                [Field::ID => ($extra ? Constant::CST_DESC : Constant::CST_ASC)]
            );

            if ($objHerosFeat === null || $objHerosFeat->getField(Field::ID) === 0) {
                // Cas de première création : on récupère le feat associé à l'origine
                $this->originFeatCache = $this->getOrigin()?->getOriginFeat();
            } else {
                $this->originFeatCache = $objHerosFeat->getFeat();
            }
        }
        return $this->originFeatCache;
    }

    public function getFeats(): Collection
    {
        return $this->getRelatedCollection(
            RepositoryRpgHerosFeat::class,
            [Field::HEROSID => $this->id],
            [Field::ID => Constant::CST_ASC]
        );
    }

    public function getSkills(): Collection
    {
        return $this->getRelatedCollection(
            RepositoryRpgHerosSkill::class,
            [Field::HEROSID => $this->id],
            [Field::ID => Constant::CST_ASC]
        );
    }

    public function delete(): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $obj = new RepositoryRpgHeros($queryBuilder, $queryExecutor, self::TABLE, self::FIELDS);
        $obj->delete($this);
    }

}
