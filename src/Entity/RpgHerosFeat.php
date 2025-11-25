<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgClasse as RepositoryRpgClasse;

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

    private ?RpgHeros $herosCache = null;
    private ?RpgFeat $featCache = null;
    private ?RpgClasse $classeCache = null;

    public function getHeros(): ?RpgHeros
    {
        return $this->getRelatedEntity('herosCache', RepositoryRpgHeros::class, $this->herosId);
    }

    public function getFeat(): ?RpgFeat
    {
        return $this->getRelatedEntity('featCache', RepositoryRpgFeat::class, $this->featId);
    }

    public function getClasse(): ?RpgClasse
    {
        return $this->getRelatedEntity('classeCache', RepositoryRpgClasse::class, $this->extra);
    }

    public function getFullName(): string
    {
        $feat = $this->getFeat();
        if (!$feat) {
            return 'Feat inconnu';
        }

        $str = $feat->getField(Field::NAME);
        if ($this->extra !== 0 && $classe = $this->getClasse()) {
            $str .= ' (' . $classe->getName() . ')';
        }

        return $str;
    }

}
