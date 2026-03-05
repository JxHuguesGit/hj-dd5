<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
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
            Constant::TITLE       => $viewData->origin->name,
            Constant::SLUG        => $viewData->origin->getSlug(),

            Constant::ABILITIES   => $this->formatAbilities($viewData->abilities),
            Constant::SKILLS      => $viewData->skills,

            Constant::DESCRIPTION => $this->cleanContent($wpPost->post_content),
            Constant::FEAT        => $viewData->feat ? [
                Constant::NAME => $viewData->feat->name,
                Constant::SLUG => $viewData->feat->getSlug(),
            ] : null,
            Constant::TOOL        => $viewData->tool ? [
                Constant::NAME => $viewData->tool->name,
                Constant::SLUG => $viewData->tool->getSlug(),
            ] : null,
            Constant::EQUIPMENT   => $this->formatItems($viewData->items),

            Constant::PREV        => $viewData->previous ? [
                Constant::NAME => $viewData->previous->name,
                Constant::SLUG => $viewData->previous->getSlug(),
            ] : null,
            Constant::NEXT        => $viewData->next ? [
                Constant::NAME => $viewData->next->name,
                Constant::SLUG => $viewData->next->getSlug(),
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
