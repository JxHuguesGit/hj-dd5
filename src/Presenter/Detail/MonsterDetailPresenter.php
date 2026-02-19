<?php
namespace src\Presenter\Detail;

use src\Domain\Monster\Monster;
use src\Service\Formatter\MonsterFormatter;

class MonsterDetailPresenter
{
    public function __construct(
        private MonsterFormatter $formatter,
        private Monster $monster
    ) {}

    public function present(): array
    {
        return [
            $this->formatter->formatName($this->monster->name, $this->monster->frName),
            $this->formatter->formatTypeAndAlignement($this->monster),
            $this->formatter->formatCA($this->monster),
            $this->monster->combat()->getInitiative(),
            $this->formatter->formatHP($this->monster),
            '',//Speed,
            $this->formatter->formatScore($this->monster, 'str'),
            $this->formatter->formatScore($this->monster, 'dex'),
            $this->formatter->formatScore($this->monster, 'con'),
            $this->formatter->formatScore($this->monster, 'int'),
            $this->formatter->formatScore($this->monster, 'wis'),
            $this->formatter->formatScore($this->monster, 'cha'),
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
}
