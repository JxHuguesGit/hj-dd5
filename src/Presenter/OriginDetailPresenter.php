<?php
namespace src\Presenter;

use src\Constant\Constant;
use src\Presenter\ViewModel\OriginPageView;

class OriginDetailPresenter
{
    public function present(
        OriginPageView $viewData
    ): array {
        // Capacités
        $abilities = [];
        foreach ($viewData->abilities as $ability) {
            $abilities[] = $ability->name;
        }

        // Compétences
        $skills = [];
        foreach ($viewData->skills as $skill) {
            $skills[] = $skill->name;
        }

        $wpPost = get_post($viewData->origin->postId);
        $strContent = $wpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);
        $strItem = get_field(Constant::CST_EQUIPMENT, $wpPost->ID);

        return [
            Constant::CST_TITLE => $viewData->origin->name,
            Constant::CST_SLUG  => $viewData->origin->getSlug(),

            Constant::CST_ABILITIES => $abilities,
            Constant::CST_SKILLS    => $skills,

            Constant::CST_DESCRIPTION => $strContent,
            Constant::CST_FEATNAME    => $viewData->feat?->name,
            Constant::CST_FEATSLUG    => $viewData->feat?->getSlug(),
            Constant::CST_TOOLNAME    => $viewData->tool?->name,
            Constant::CST_EQUIPMENT   => $strItem,

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
                Constant::CST_NAME => $viewData?->previous->name,
            ] : null,

            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_SLUG => $viewData->next->getSlug(),
                Constant::CST_NAME => $viewData->next->name,
            ] : null,
        ];
    }
}
