<?php
namespace src\Presenter\Detail;

use src\Domain\Monster\Monster;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\MonsterSubTypeRepository;
use src\Repository\MonsterTypeRepository;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\MonsterSubTypeReader;
use src\Service\Reader\MonsterTypeReader;

class MonsterDetailPresenter
{
    public function __construct(
        private Monster $monster
    ) {}

    public function present(): array
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $formatter = new MonsterFormatter(
            new MonsterTypeReader(new MonsterTypeRepository($qb, $qe)),
            new MonsterSubTypeReader(new MonsterSubTypeRepository($qb, $qe)),
        );

        $objsTrait = $this->getTraits();


        return [
            $formatter->formatName($this->monster->name, $this->monster->frName),
            $formatter->formatTypeAndAlignement($this->monster),
            $formatter->formatCA($this->monster),
            $this->monster->combat()->getInitiative(),
            $formatter->formatHP($this->monster),
            '',//Speed,
            $formatter->formatScore($this->monster, 'str'),
            $formatter->formatScore($this->monster, 'dex'),
            $formatter->formatScore($this->monster, 'con'),
            $formatter->formatScore($this->monster, 'int'),
            $formatter->formatScore($this->monster, 'wis'),
            $formatter->formatScore($this->monster, 'cha'),
            '',
            // d-none si pas de Traits
            //empty($objsTrait) ? ' '.Bootstrap::CSS_DNONE : '',
            '',
            //$this->getSpecialAbilitiesList($objsTrait), // Liste des traits
            '',
            // d-none si pas d'Actions
            //empty($objsActions) ? ' '.Bootstrap::CSS_DNONE : '',
            '',
            // Liste des actions
            //$this->getSpecialAbilitiesList($objsActions),
            '',
            // d-none si pas de Bonus actions
            //empty($objsBonusActions) ? ' '.Bootstrap::CSS_DNONE : '',
            '',
            //$this->getSpecialAbilitiesList($objsBonusActions), // Liste des Bonus actions
            '',
            // d-none si pas de Réactions
            //empty($objsReactions) ? ' '.Bootstrap::CSS_DNONE : '',
            //$this->getSpecialAbilitiesList($objsReactions), // Liste des Réactions
            '',
            // d-none si pas de Legendary Actions
            //empty($objsActionsLegendaires) ? ' '.Bootstrap::CSS_DNONE : '',
            //$this->getSpecialAbilitiesList($objsActionsLegendaires), // Liste des Actions Légendaires
            '',

            '', '', '', '',
            '', '', '', '',
            '', '', '', '',
            '', '', '', '',
            '', '', '', '',
        ];
    }

    public function getTraits(): array
    {
        return [];//$this->monster->getAbilities()->getTraits()->toArray();
    }

}
