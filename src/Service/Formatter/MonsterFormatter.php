<?php
namespace src\Service\Formatter;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Icon;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;
use src\Helper\SizeHelper;
use src\Service\Calculator\MonsterCalculator;
use src\Utils\Html;
use src\Utils\Utils;

class MonsterFormatter
{
    public function __construct(
        private ReaderFactory $readerFactory
    ) {}

    public function formatName(string $ukName, string $frName): string
    {
        return $frName != '' ? $frName . ' (' . $ukName . ')' : $ukName;
    }

    public function formatNameWithFlags(
        string $name,
        bool $isComplete,
        string $ukTag,
        string $frTag
    ): string {
        $html = '<span class="modal-tooltip" data-modal="monster" data-uktag="' . $ukTag . '">'
        . $name . ' ' . Html::getIcon(Icon::ISEARCH) . '</span>';

        if (! $isComplete) {
            $html .= '<i class="float-end">🇬🇧</i>';
            if ($frTag !== 'non') {
                $html .= '<i class="float-end">🇫🇷</i>';
            }
        }
        return $html;
    }

    public function formatCA(Monster $monster): string
    {
        $ca    = $monster->combat()->getArmorClass() ?? 10;
        $extra = $monster->getExtra(Field::SCORECA) ?? '';
        if ($extra !== '') {
            $ca .= ' (' . $extra . ')';
        }
        return $ca;
    }

    public function formatInitiative(Monster $monster): string
    {
        $score = $monster->combat()->getInitiative();
        return ($score < 0 ? '' : '+') . $score . ' (' . (10 + $score) . ')';
    }

    public function formatHP(Monster $monster): string
    {
        $hp    = $monster->combat()->getHitPoints() ?? 0;
        $extra = $monster->getExtra(Field::SCOREHP) ?? '';
        if ($extra !== '') {
            $hp .= ' ' . $extra;
        }
        return $hp;
    }

    public function formatCR(float | int $cr): string
    {
        return match ($cr) {
            -1      => 'aucun',
            0.125   => '1/8',
            0.25    => '1/4',
            0.5     => '1/2',
            default => (string) $cr,
        };
    }

    public function formatType(Monster $monster): string
    {
        $gender = '';

        // Type principal
        $type                                                   = $this->readerFactory->monsterType()->monsterTypeById($monster->monstreTypeId);
        [Constant::CST_LABEL => $typeName, 'gender' => $gender] = $type?->getNameAndGender();

        // Nuée
        if ($monster->swarmSize) {
            $sizeLabel = SizeHelper::toLabelFr($monster->swarmSize, $gender, true);
            $typeName  = "Nuée de $sizeLabel $typeName" . 's';
        }

        // Sous-type
        if ($monster->monsterSubTypeId) {
            $subType = $this->readerFactory->monsterSubType()->monsterSubTypeById($monster->monsterSubTypeId);
            if ($subType) {
                $typeName .= ' (' . $subType->getStrName() . ')';
            }
        }

        return $typeName;
    }

    public function formatScore(Monster $monster, string $carac): string
    {
        $score        = $monster->stats()->getScore($carac) ?? 0;
        $mod          = Utils::getModAbility($score);
        $bonus        = $monster->getExtra('js' . $carac) ?: 0;
        $modWithBonus = Utils::getModAbility($score, $bonus);
        $mentalStats  = in_array($carac, ['int', 'wis', 'cha']);
        return sprintf(
            '<div class="col %s">%d</div><div class="col %s">%+d</div><div class="col %s">%+d</div>',
            'car' . (2 + 3 * $mentalStats), $score,
            'car' . (3 + 3 * $mentalStats), $mod,
            'car' . (3 + 3 * $mentalStats), $modWithBonus
        );
        //return sprintf("%d (%+d / %+d)", $score, $mod, $modWithBonus);
    }

    public function formatTypeAndAlignement(Monster $monster): string
    {
        $type      = $this->formatType($monster);
        $alignment = $monster->getField(Field::ALGNID) ?? '';
        return $type . ' de taille xx' . ($alignment ? ', ' . $alignment : '');
    }

    public function formatSkills(Collection $monsterSkills): string
    {
        if ($monsterSkills->isEmpty()) {
            return '';
        }
        $skills = [];
        foreach ($monsterSkills as $monsterSkill) {
            $skill    = $this->readerFactory->skill()->skillById($monsterSkill->skillId);
            $skills[] = $skill->name . ' +' . $monsterSkill->value;
        }

        return '<div class="col-12"><strong>Compétences</strong> ' . implode(', ', $skills) . '</div>';
    }

    public function formatImmunites(Collection $monsterResistances, Collection $monsterConditions): string
    {
        if ($monsterResistances->isEmpty() && $monsterConditions->isEmpty()) {
            return '';
        }
        $resistances = [];
        foreach ($monsterResistances as $monsterResistance) {
            $damageType    = $this->readerFactory->damageType()->damageTypeById($monsterResistance->typeDamageId);
            $resistances[] = $damageType->name;
        }

        $conditions = [];
        foreach ($monsterConditions as $monsterCondition) {
            $condition    = $this->readerFactory->condition()->conditionById($monsterCondition->conditionId);
            $conditions[] = $condition->name;
        }

        return Html::getDiv(
            Html::getBalise('strong', 'Immunités') . ' '
            . implode('; ', [implode(', ', $resistances), implode(', ', $conditions)]),
            [Constant::CST_CLASS => Bootstrap::CSS_COL_12]
        );
    }

    public function formatResistances(Collection $monsterResistances, string $type): string
    {
        if ($monsterResistances->isEmpty()) {
            return '';
        }
        $resistances = [];
        foreach ($monsterResistances as $monsterResistance) {
            if ($monsterResistance->typeResistanceId != $type) {
                continue;
            }
            $damageType    = $this->readerFactory->damageType()->damageTypeById($monsterResistance->typeDamageId);
            $resistances[] = $damageType->name;
        }
        if (empty($resistances)) {
            return '';
        }

        if ($type == 'R') {
            $label = 'Résistances';
        } elseif ($type == 'V') {
            $label = 'Vulnérabilités';
        } else {
            $label = 'Erreur';
        }

        return Html::getDiv(
            Html::getBalise('strong', $label) . ' ' . implode(', ', $resistances),
            [Constant::CST_CLASS => Bootstrap::CSS_COL_12]
        );
    }

    public function formatSenses(Monster $monster): string
    {
        $str    = '';
        $comma  = false;
        //////////////////////////////////////////////////////////////
        // Gestion des sens du monstre
        $str .= '<div class="col-12"><strong>Sens</strong> ';

        // Perception passive.
        $str .= ($comma ? ', ' : '') . 'Perception passive ' . $monster->percPassive;

        $str .= '</div>';
        //////////////////////////////////////////////////////////////
        return $str;
        $objs  = $this->rpgMonster->getSenses();
        if (! $objs->isEmpty()) {
            $comma = false;
            $objs->rewind();
            while ($objs->valid()) {
                if ($comma) {
                    $str .= ', ';
                }
                $obj    = $objs->current();
                $str   .= $obj->getController()->getFormatString();
                $comma  = true;
                $objs->next();
            }
        }
        $senses = $this->rpgMonster->getExtra('senses');
        if ($senses != '') {
            $str   .= ($comma ? ', ' : '') . $senses;
            $comma  = true;
        }
        return $str;
    }

    public function formatLanguages(Monster $monster): string
    {
        $languageReader        = $this->readerFactory->language();
        $monsterLanguageReader = $this->readerFactory->monsterLanguage();
        $monsterLanguages      = $monsterLanguageReader->monsterLanguagesByMonsterId($monster->id);
        $languages             = [];
        foreach ($monsterLanguages as $monsterLanguage) {
            $language    = $languageReader->languageById($monsterLanguage->languageId);
            $languages[] = $language->name . ($monsterLanguage->value != 0 ? ' ' . $monsterLanguage->value . ' m' : '');
        }
        return Html::getDiv(
            Html::getBalise('strong', 'Langues') . ' ' . (empty($languages) ? 'Aucune' : implode(', ', $languages)),
            [Constant::CST_CLASS => Bootstrap::CSS_COL_12]
        );
    }

    public function formatFpXpBm(Monster $monster): string
    {
        $extraPx = $monster->getExtra(Field::SCOREXP) ?? '';
        $extraPb = $monster->getExtra(Field::SCOREPB) ?? '';
        $bm      = $monster->profBonus;

        $content  = $this->formatCR($monster->cr);
        $content .= ' (PX ' . MonsterCalculator::calculateXp($monster->cr) . $extraPx;
        $content .= ' ; BM ' . ($bm == 0 ? '' : '+' . $bm) . $extraPb . ')</div>';

        return Html::getDiv(
            Html::getBalise('strong', 'FP') . ' ' . $content,
            [Constant::CST_CLASS => Bootstrap::CSS_COL_12]
        );
    }

    public function formatAbility(string $name, string $description): string
    {
        $strContent = Utils::formatBBCode($description);
        return $name == 'legend'
            ? sprintf('<p>%s</p>', $strContent)
            : sprintf('<p><strong><em>%s</em></strong>. %s</p>', $name, $strContent);
    }
}
