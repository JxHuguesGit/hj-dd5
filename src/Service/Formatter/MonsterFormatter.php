<?php
namespace src\Service\Formatter;

use src\Constant\Field;
use src\Constant\Icon;
use src\Domain\Monster\Monster;
use src\Helper\SizeHelper;
use src\Service\Reader\SousTypeMonsterReader;
use src\Service\Reader\TypeMonsterReader;
use src\Utils\Html;
use src\Utils\Utils;

class MonsterFormatter
{
    public function __construct(
        private TypeMonsterReader $typeReader,
        private SousTypeMonsterReader $sousTypeReader,
    ) {}

    public function formatName(string $ukName, string $frName): string
    {
        return $frName!='' ? $frName . ' (' . $ukName . ')' : $ukName;
    }

    public function formatNameWithFlags(
        string $name,
        bool $isComplete,
        string $ukTag,
        string $frTag
    ): string {
        $html = '<span class="modal-tooltip" data-modal="monster" data-uktag="'.$ukTag.'">'
              . $name . ' ' . Html::getIcon(Icon::ISEARCH) . '</span>';

        if (!$isComplete) {
            $html .= '<i class="float-end">🇬🇧</i>';
            if ($frTag !== 'non') {
                $html .= '<i class="float-end">🇫🇷</i>';
            }
        }
        return $html;
    }

    public function formatCA(Monster $monster): string
    {
        $ca = $monster->combat()->getArmorClass() ?? 10;
        $extra = $monster->getExtra('ca') ?? '';
        if ($extra !== '') {
            $ca .= ' (' . $extra . ')';
        }
        return $ca;
    }

    public function formatHP(Monster $monster): string
    {
        $hp = $monster->combat()->getHitPoints() ?? 0;
        $extra = $monster->getExtra('hp') ?? '';
        if ($extra !== '') {
            $hp .= ' ' . $extra;
        }
        return $hp;
    }

    public function formatCR(float|int $cr): string
    {
        return match ($cr) {
            -1 => 'aucun',
            0.125 => '1/8',
            0.25 => '1/4',
            0.5 => '1/2',
            default => (string)$cr,
        };
    }

    public function formatType(Monster $monster): string
    {
        $gender = '';
var_dump($monster);
        // Type principal
        $type = $this->typeReader->typeMonsterById($monster->monstreTypeId);
        ['label'=>$typeName, 'gender'=>$gender] = $type?->getNameAndGender();

        // Nuée
        if ($monster->swarmSize) {
            $sizeLabel = SizeHelper::toLabelFr($monster->swarmSize, $gender, true);
            $typeName = "Nuée de $sizeLabel $typeName" . 's';
        }

        // Sous-type
        if ($monster->monsterSubTypeId) {
            $subType = $this->sousTypeReader->typeMonsterById($monster->monsterSubTypeId);
            if ($subType) {
                $typeName .= ' (' . $subType->getStrName() . ')';
            }
        }

        return $typeName;
    }

    public function formatScore(Monster $monster, string $carac): string
    {
        $score = $monster->stats()->getScore($carac) ?? 0;
        $mod = Utils::getModAbility($score);
        $bonus = $monster->getExtra('js'.$carac) ?: 0;
        $modWithBonus = Utils::getModAbility($score, $bonus);
        return sprintf("%d (%+d / %+d)", $score, $mod, $modWithBonus);
    }

    public function formatTypeAndAlignement(Monster $monster): string
    {
        $type = $this->formatType($monster);
        //$alignment = $monster->getField(Field::ALIGNEMENT) ?? '';
        return $type ;//. ($alignment ? ', ' . $alignment : '');
    }
}
