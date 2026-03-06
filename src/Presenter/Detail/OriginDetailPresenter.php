<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
            C::TITLE       => $viewData->origin->name,
            C::SLUG        => $viewData->origin->getSlug(),

            C::ABILITIES   => $this->formatAbilities($viewData->abilities),
            C::SKILLS      => $viewData->skills,

            C::DESCRIPTION => $this->cleanContent($wpPost->post_content),
            C::FEAT        => $viewData->feat ? [
                C::NAME => $viewData->feat->name,
                C::SLUG => $viewData->feat->getSlug(),
            ] : null,
            C::TOOL        => $viewData->tool ? [
                C::NAME => $viewData->tool->name,
                C::SLUG => $viewData->tool->getSlug(),
            ] : null,
            C::EQUIPMENT   => $this->formatItems($viewData->items),

            C::PREV        => $viewData->previous ? [
                C::NAME => $viewData->previous->name,
                C::SLUG => $viewData->previous->getSlug(),
            ] : null,
            C::NEXT        => $viewData->next ? [
                C::NAME => $viewData->next->name,
                C::SLUG => $viewData->next->getSlug(),
            ] : null,
        ];
    }

    private function formatItems(iterable $items): array
    {
        $cache = [];
        foreach ($items as $item) {
            $cache[$item->slug]['quantity'] = ($cache[$item->slug]['quantity'] ?? 0) + 1;
            $cache[$item->slug]['item']     = $item;
        }
        return array_map(fn($data) => $data['quantity'] . ' ' . Html::getLink($data['item']->name, UrlGenerator::item($data['item']->slug), B::TEXT_DARK), $cache);
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
