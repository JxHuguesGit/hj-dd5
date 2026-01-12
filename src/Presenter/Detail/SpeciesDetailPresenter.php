<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Presenter\ViewModel\SpeciePageView;
use src\Service\WpPostService;

class SpeciesDetailPresenter
{
    public function present(
        SpeciePageView $viewData
    ): array {
        $wpPostService = new WpPostService();
        $wpPost = $wpPostService->getById($viewData->species->postId);

        // Capacités
        $abilities = [];
        foreach ($viewData->abilities as $ability) {
            $abilities[] = $ability->name;
        }

        $strContent = $wpPost->post_content;

        return [
            Constant::CST_TITLE => $viewData->species->name,
            Constant::CST_SLUG  => $viewData->species->getSlug(),

            Constant::CST_DESCRIPTION   => $strContent,
            Constant::CST_CREATURE_TYPE => $wpPost->getField(Constant::CST_CREATURE_TYPE),
            Constant::CST_SIZE_CATEGORY => $wpPost->getField(Constant::CST_SIZE_CATEGORY),
            Constant::CST_SPEED         => $wpPost->getField(Constant::CST_SPEED),
            Constant::CST_POWERS        => $abilities,

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
                Constant::CST_NAME => $viewData?->previous->name,
            ] : null,

            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_SLUG => $viewData?->next->getSlug(),
                Constant::CST_NAME => $viewData?->next->name,
            ] : null,
        ];
    }
}
