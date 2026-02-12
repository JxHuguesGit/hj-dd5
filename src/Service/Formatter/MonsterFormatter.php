<?php
namespace src\Service\Formatter;

use src\Constant\Icon;
use src\Domain\Entity\Monster;
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
        $score = $monster->getStats()->{"{$carac}Score"} ?? 0;
        $mod = Utils::getModAbility($score);
        $bonus = 0;//$monster->getExtra('js'.$carac) ?: 0;
        $modWithBonus = Utils::getModAbility($score, $bonus);
        return sprintf("%d (%+d / %+d)", $score, $mod, $modWithBonus);
    }
}
