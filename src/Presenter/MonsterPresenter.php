<?php
namespace src\Presenter;

use src\Entity\RpgMonster;
use src\Entity\RpgReference;
use src\Utils\Utils;
use src\Helper\SizeHelper;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgTypeMonstre;
use src\Repository\RpgSousTypeMonstre;
use src\Repository\RpgReference as RepositoryRpgReference;

class MonsterPresenter
{
    private RpgMonster $monster;
    private QueryBuilder $queryBuilder;
    private QueryExecutor $queryExecutor;

    public function __construct(RpgMonster $monster)
    {
        $this->monster = $monster;
        $this->queryBuilder  = new QueryBuilder();
        $this->queryExecutor = new QueryExecutor();
    }

    // -----------------------
    // Nom et type
    // -----------------------
    public function getStrName(): string
    {
        return $this->monster->frName ?: $this->monster->name;
    }

    public function getStrType(): string
    {
        $objDao = new RpgTypeMonstre($this->queryBuilder, $this->queryExecutor);
        $objTypeMonstre = $objDao->find($this->monster->getMonstreTypeId());
        $gender = '';
        $typeName = $objTypeMonstre?->getStrName($gender) ?? '';

        // Nuée
        if ($this->monster->getSwarmSize()) {
            $typeName = 'Nuée de ' . SizeHelper::toLabelFr($this->monster->getSwarmSize(), $gender) . ' ' . $typeName . 's';
        }

        // Sous-type
        if ($this->monster->getMonsterSubTypeId()) {
            $objSousTypeDao = new RpgSousTypeMonstre($this->queryBuilder, $this->queryExecutor);
            $subType = $objSousTypeDao->find($this->monster->getMonsterSubTypeId());
            $typeName .= ' (' . ($subType?->getStrName() ?? '') . ')';
        }

        return $typeName;
    }

    // -----------------------
    // CR et XP
    // -----------------------
    public function getCR(): string
    {
        return match ($this->monster->getCr()) {
            -1 => 'aucun',
            0.125 => '1/8',
            0.25 => '1/4',
            0.5 => '1/2',
            default => (string)$this->monster->getCr(),
        };
    }

    public function getXP(): string
    {
        $xpMap = [
            -1 => 0, 0 => 10, 0.125 => 25, 0.25 => 50, 0.5 => 100,
            1 => 200, 2 => 450, 3 => 700, 4 => 1100, 5 => 1800,
            6 => 2300, 8 => 3900, 9 => 5000, 10 => 5900, 14 => 11500, 16 => 15000,
        ];
        $xp = $xpMap[$this->monster->getCr()] ?? 0;
        return number_format($xp, 0, ',', ' ');
    }

    // -----------------------
    // Scores de caractéristiques
    // -----------------------
    public function getScore(string $carac): string
    {
        $score = $this->monster->getStats()->{"{$carac}Score"} ?? 0;
        $score = $this->monster->{"{$carac}Score"} ?? 0;
        $mod = Utils::getModAbility($score);
        $bonus = $this->monster->getExtra('js'.$carac) ?: 0;
        $modWithBonus = Utils::getModAbility($score, $bonus);
        return sprintf("%d (%+d / %+d)", $score, $mod, $modWithBonus);
    }

    // -----------------------
    // Modificateurs
    // -----------------------
    public function getScoreModifier(int $value): string
    {
        return ($value >= 0 ? '+' : '') . $value;
    }

    public function getStrModifier(int $value): string
    {
        return $this->getScoreModifier($value);
    }

    // -----------------------
    // Initiative et vitesse
    // -----------------------
    public function getInitiative(): string
    {
        return ($this->monster->getInitiative() >= 0 ? '+' : '') . $this->monster->getInitiative();
    }

    public function getSpeed(): string
    {
        $value = $this->monster->getVitesse() . ' m';
        // exemple, remplacer par typeSpeed si nécessaire
        $objs = $this->monster->getSenses();
        foreach ($objs as $obj) {
            $value .= ', ' . $obj->getController()->getFormatString();
        }
        $extra = $this->monster->getExtra('vitesse');
        if ($extra) {
            $value .= $extra;
        }
        return $value;
    }

    // -----------------------
    // Actions et capacités
    // -----------------------
    public function getTraits(): array
    {
        return $this->monster->getAbilities()->getTraits()->toArray();
    }

    public function getActions(): array
    {
        return $this->monster->getAbilities()->getActions()->toArray();
    }

    public function getBonusActions(): array
    {
        return $this->monster->getAbilities()->getBonusActions()->toArray();
    }

    public function getReactions(): array
    {
        return $this->monster->getAbilities()->getReactions()->toArray();
    }

    public function getLegendaryActions(): array
    {
        return $this->monster->getAbilities()->getLegendaryActions()->toArray();
    }

    // -----------------------
    // Alignement et référence
    // -----------------------
    public function getAlignement(): ?string
    {
        return $this->monster->getAlignement()?->getStrAlignement();
    }

    public function getReference(): ?RpgReference
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgReference($queryBuilder, $queryExecutor);
        return $objDao->find($this->monster->getReferenceId());
    }

    // -----------------------
    // Autres extras
    // -----------------------
    public function getExtra(string $field): mixed
    {
        return $this->monster->getExtra($field);
    }
}
