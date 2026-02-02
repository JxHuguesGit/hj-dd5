<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\OriginPageView;
use src\Service\Domain\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class OriginDetailPresenter
{
    public function __construct(
        private WpPostService $wpPostService
    ) {}

    public function present(
        OriginPageView $viewData
    ): array {
        $wpPost = $this->wpPostService->getById($viewData->origin->postId ?? 0);

        return [
            Constant::CST_TITLE => $viewData->origin->name,
            Constant::CST_SLUG  => $viewData->origin->getSlug(),

            Constant::CST_ABILITIES => $this->formatAbilities($viewData->abilities),
            Constant::CST_SKILLS    => $viewData->skills,

            Constant::CST_DESCRIPTION => $this->cleanContent($wpPost->post_content),
            Constant::CST_FEAT        => $viewData->feat ? [
                Constant::CST_NAME => $viewData->feat->name,
                Constant::CST_SLUG => $viewData->feat->getSlug(),
            ] : null,
            Constant::CST_TOOL        => $viewData->tool ? [
                Constant::CST_NAME => $viewData->tool->name,
                Constant::CST_SLUG => $viewData->tool->getSlug(),
            ] : null,
            Constant::CST_EQUIPMENT   => $this->formatItems($viewData->items),

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_NAME => $viewData->previous->name,
                Constant::CST_SLUG => $viewData->previous->getSlug(),
            ] : null,
            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_NAME => $viewData->next->name,
                Constant::CST_SLUG => $viewData->next->getSlug(),
            ] : null,
        ];
    }

    private function formatItems(iterable $items): array
    {
        $cache = [];
        foreach ($items as $item) {
            $cache[$item->slug]['quantity'] = ($cache[$item->slug]['quantity'] ?? 0) + 1;
            $cache[$item->slug]['item'] = $item;
        }
        return array_map(fn($data) => $data['quantity'].' '.Html::getLink( $data['item']->name, UrlGenerator::item($data['item']->slug), Bootstrap::CSS_TEXT_DARK ), $cache);
    }

    private function formatAbilities(iterable $abilities): array
    {
        return array_map(fn($a) => $a->name, $abilities->toArray());
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
