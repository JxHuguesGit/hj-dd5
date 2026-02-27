<?php
namespace src\Presenter\Detail;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Domain\Entity\MonsterResistance;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\PowerReader;

class MonsterDetailPresenter
{
    private ?PowerReader $powerReader = null;

    public function __construct(
        private ReaderFactory $readerFactory,
        private MonsterFormatter $formatter,
        private Monster $monster
    ) {}

    public function present(): array
    {
        $objsTrait              = $this->monster->traits();
        $objsActions            = $this->monster->actions();
        $objsBonusActions       = $this->monster->bonusActions();
        $objsReactions          = $this->monster->reactions();
        $objsActionsLegendaires = $this->monster->legendaryActions();

        $speedTypeReader = $this->readerFactory->speedType();
        $speedTypes      = $speedTypeReader->allSpeedTypes();
        $speeds          = [];
        foreach ($speedTypes as $speedType) {
            $monsterSpeed = $this->monster->speed($speedType->id);
            if ($monsterSpeed === null) {
                continue;
            }
            $speeds[] = ($speedType->frTag == 'marche' ? '' : $speedType->name . ' ') . $monsterSpeed->value . ' m';
        }

        return [
            $this->formatter->formatName($this->monster->name, $this->monster->frName),
            $this->formatter->formatTypeAndAlignement($this->monster),
            $this->formatter->formatCA($this->monster),
            $this->formatter->formatInitiative($this->monster),
            $this->formatter->formatHP($this->monster),
            implode(', ', $speeds),
            $this->formatter->formatScore($this->monster, 'str'),
            $this->formatter->formatScore($this->monster, 'dex'),
            $this->formatter->formatScore($this->monster, 'con'),
            $this->formatter->formatScore($this->monster, 'int'),
            $this->formatter->formatScore($this->monster, 'wis'),
            $this->formatter->formatScore($this->monster, 'cha'),
            $this->getSkillsToCR(),
            $objsTrait->isEmpty() ? ' ' . Bootstrap::CSS_DNONE : '',
            $this->getSpecialAbilitiesList($objsTrait),
            $objsActions->isEmpty() ? ' ' . Bootstrap::CSS_DNONE : '',
            $this->getSpecialAbilitiesList($objsActions),
            $objsBonusActions->isEmpty() ? ' ' . Bootstrap::CSS_DNONE : '',
            $this->getSpecialAbilitiesList($objsBonusActions),
            $objsReactions->isEmpty() ? ' ' . Bootstrap::CSS_DNONE : '',
            $this->getSpecialAbilitiesList($objsReactions),
            $objsActionsLegendaires->isEmpty() ? ' ' . Bootstrap::CSS_DNONE : '',
            $this->getSpecialAbilitiesList($objsActionsLegendaires),
        ];
    }

    private function getSpecialAbilitiesList(Collection $objs): string
    {
        if ($this->powerReader === null) {
            $this->powerReader = $this->readerFactory->power();
        }
        $str = '';
        foreach ($objs as $obj) {
            $power  = $this->powerReader->powerById($obj->powerId);
            $str   .= $this->formatter->formatAbility($power->name, $power->description);
        }
        return $str;
    }

    private function getSkillsToCR(): string
    {
        // Gestion des compétences du monstre
        $str          = $this->formatter->formatSkills($this->monster->skills());
        $conditions   = $this->monster->conditions();
        $resistances  = $this->monster->resistances();
        // Gestion des vulnérabiliés du monstre
        $str .= $this->formatter->formatResistances($resistances, 'V');
        // Gestion des résistances du monstre
        $str .= $this->formatter->formatResistances($resistances, 'R');
        // Gestion des immunités du monstre
        $str .= $this->formatter->formatImmunites(
            $resistances->filter(fn(MonsterResistance $r) => $r->typeResistanceId == 'I'),
            $conditions
        );
        // Gestion des sens du monstre
        $str .= $this->formatter->formatSenses($this->monster);
        // Gestion des langues du monstre
        $str .= $this->formatter->formatLanguages($this->monster);
        // Gestion du FP, des XPs et du BM
        $str .= $this->formatter->formatFpXpBm($this->monster);
        return $str;
    }

}
