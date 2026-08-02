<?php

namespace src\Presenter\ContentBuilder;

use src\Collection\Collection;
use src\Constant\Language as L;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Utils\Html;

final class WeaponCardContentBuilder implements ContentBuilderInterface
{
    public function build(object $groups, array $params = []): string
    {
        $content = '<div class="weapon-list">';

        foreach ($groups as $group) {
            /** @var WeaponGroup $group */
            $content .= '<div class="weapon-group">';
            $content .= '<h2>' . $group->label . '</h2>';
            $content .= '<div class="weapon-grid">';

            foreach ($group->rows as $row) {
                /** @var WeaponRow $row */
                $content .= '<article class="weapon-card">';
                $content .= '<h3>'
                    . Html::getLink($row->name, $row->url)
                    . '</h3>';

                $content .= '<div class="weapon-card-info"><strong>' . L::DAMAGES . '</strong> '
                    . $row->damage . '</div>';

                $content .= '<div class="weapon-card-info"><strong>' . L::PROPERTIES . '</strong> <span class="weapon-properties">'
                    . $row->properties . '</span></div>';

                $content .= '<div class="weapon-card-info"><strong>' . L::WEAPON_PROP . '</strong> '
                    . $row->masteryLink . '</div>';

                $content .= '<div class="weapon-card-info"><strong>' . L::WEIGHT . '</strong> '
                    . $row->weight . '</div>';

                $content .= '<div class="weapon-card-info"><strong>' . L::PRICE . '</strong> '
                    . $row->price . '</div>';

                $content .= '</article>';
            }

            $content .= '</div></div>';
        }

        return $content . '</div>';
    }
}
