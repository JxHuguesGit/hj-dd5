<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\OriginPageView;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class OriginDetailPresenter
{
    public function present(
        OriginPageView $viewData
    ): array {
        $wpPostService = new WpPostService();
        $wpPost = $wpPostService->getById($viewData->origin->postId);

        // Capacités
        $abilities = [];
        foreach ($viewData->abilities as $ability) {
            $abilities[] = $ability->name;
        }

        $strContent = $wpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);
        $strItem = $wpPostService->getField(Constant::CST_EQUIPMENT);

        $items = [];
        $itemsCache = [];
        foreach ($viewData->items as $item) {
            if (isset($itemsCache[$item->slug])) {
                ++$itemsCache[$item->slug]['quantity'];
            } else {
                $itemsCache[$item->slug] = [
                    'quantity' => 1,
                    'item'     => $item,
                ];
            }
        }
        foreach ($itemsCache as $data) {
            $items[] = $data['quantity']
                . ' ' . Html::getLink(
                    $data['item']->name,
                    UrlGenerator::item($data['item']->slug),
                    Bootstrap::CSS_TEXT_DARK
                );
        }

        return [
            Constant::CST_TITLE => $viewData->origin->name,
            Constant::CST_SLUG  => $viewData->origin->getSlug(),

            Constant::CST_ABILITIES => $abilities,
            Constant::CST_SKILLS    => $viewData->skills,

            Constant::CST_DESCRIPTION => $strContent,
            Constant::CST_FEATNAME    => $viewData->feat?->name,
            Constant::CST_FEATSLUG    => $viewData->feat?->getSlug(),
            Constant::CST_TOOLNAME    => $viewData->tool?->name,
            Constant::CST_TOOLSLUG    => $viewData->tool?->getSlug(),
            Constant::CST_EQUIPMENT   => $items,

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
