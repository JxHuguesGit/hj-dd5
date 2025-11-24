<?php
namespace src\Entity;

use src\Constant\Constant;
use src\Constant\Field;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Repository\RpgHerosFeat as RepositoryRpgHeroFeat;
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

    private ?RpgOrigin $originCache = null;
    private ?RpgSpecies $speciesCache = null;
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
        return sprintf(
            "[%s] %s",
            $this->getId(),
            $this->getName()
        );
    }

    public function getOrigin(): ?RpgOrigin
    {
        if ($this->originCache === null) {
            $objDao = new RepositoryRpgOrigin($this->qb, $this->qe);
            $this->originCache = $objDao->find($this->originId);
        }
        return $this->originCache;
    }

    public function getStrClasses(): string
    {
        return '';
    }

    public function getSpecies(): ?RpgSpecies
    {
        if ($this->speciesCache === null) {
            $objDao = new RepositoryRpgSpecies($this->qb, $this->qe);
            $this->speciesCache = $objDao->find($this->speciesId);
        }
        return $this->speciesCache;
    }

    public function getOriginFeat(bool $extra=false): RpgFeat
    {
        if ($this->originFeatCache === null) {
            $objDao = new RepositoryRpgHeroFeat($this->qb, $this->qe);
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
}
