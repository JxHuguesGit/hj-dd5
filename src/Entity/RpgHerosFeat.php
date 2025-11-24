<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgClasse as RepositoryRpgClasse;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgFeat as RepositoryRpgFeat;

class RpgHerosFeat extends Entity
{
    public const TABLE = 'rpgHerosFeat';
    public const FIELDS = [
        Field::ID,
        Field::HEROSID,
        Field::FEATID,
        Field::EXTRA,
    ];

    public const FIELD_TYPES = [
        Field::HEROSID => 'intPositive',
        Field::FEATID => 'intPositive',
        Field::EXTRA => 'intPositive',
    ];

    protected int $herosId = 0;
    protected int $featId = 0;
    protected int $extra = 0;

    public function getHeros(): ?RpgHeros
    {
        $objDao = new RepositoryRpgHeros($this->qb, $this->qe);
        return $objDao->find($this->herosId);
    }

    public function getFeat(): ?RpgFeat
    {
        $objDao = new RepositoryRpgFeat($this->qb, $this->qe);
        return $objDao->find($this->featId);
    }

    public function getFullName(): string
    {
        $feat = $this->getFeat();
        if (!$feat) {
            return 'Feat inconnu';
        }

        $str = $feat->getField(Field::NAME);
        if ($this->extra !== 0) {
            $objDao = new RepositoryRpgClasse($this->qb, $this->qe);
            $rpgClasse = $objDao->find($this->extra);
            $str .= $rpgClasse ? ' (' . $rpgClasse->getField(Field::NAME) . ')' : '';
        }

        return $str;
    }

}
