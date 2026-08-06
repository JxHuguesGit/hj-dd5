<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Presenter\ViewModel\SkillRow;
use src\Utils\Html;

final class SkillCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param SkillRow $row */
    protected function renderItem(object $row): string
    {
        $htmlContent = Html::getBalise(H::BALISE_H3, Html::getLink($row->name, $row->url));

        if ($row->description !== '') {
            $htmlContent .= Html::getBalise(H::BALISE_P, htmlspecialchars($row->description));
        }

        if (!empty($row->subSkills)) {
            $ulContent = '';
            foreach ($row->subSkills as $subSkill) {
                $ulContent .= Html::getLi(Html::getLink($subSkill->name, $subSkill->url));
            }
            $htmlContent .= Html::getUl($ulContent, [C::CSSCLASS => strtolower(C::SUB_SKILLS)]);
        }

        return $this->renderCard($htmlContent, B::SKILL_CARD);
    }
}
