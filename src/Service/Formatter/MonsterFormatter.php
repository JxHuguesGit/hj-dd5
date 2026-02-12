<?php
namespace src\Service\Formatter;

use src\Constant\Icon;
use src\Utils\Html;

class MonsterFormatter
{
    public function formatNameWithFlags(
        string $name,
        int $id,
        bool $isComplete,
        string $ukTag,
        string $frTag
    ): string {
        $html = '<span class="modal-tooltip" data-modal="monster" data-uktag="id-'.$id.'">'
              . $name . ' ' . Html::getIcon(Icon::ISEARCH) . '</span>';

        if (!$isComplete) {
            $html .= '<i class="float-end" data-modal="monster" data-uktag="'.$ukTag.'">🇬🇧</i>';

            if ($frTag !== 'non') {
                $html .= '<i class="float-end" data-modal="monster" data-uktag="fr-'.$frTag.'">🇫🇷</i>';
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
}
