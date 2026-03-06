<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Presenter\ViewModel\FeatPageView;
use src\Service\Domain\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class FeatDetailPresenter
{
    public function __construct(
        private WpPostService $wpPostService
    ) {}

    public function present(
        FeatPageView $viewData
    ): array {
        $wpPost = $this->wpPostService->getById($viewData->feat->postId);

        return [
            C::TITLE       => $viewData->feat->name,
            C::SLUG        => $viewData->feat->getSlug(),

            C::DESCRIPTION => $this->cleanContent($wpPost->post_content ?? ''),
            C::FEATTYPE    => $this->formatFeatType($viewData),

            C::ORIGINES        => $this->formatOrigines($viewData),

            C::PREV        => $viewData->previous ? [
                C::SLUG => $viewData?->previous->getSlug(),
                C::NAME => $viewData?->previous->name,
            ] : null,

            C::NEXT        => $viewData->next ? [
                C::SLUG => $viewData?->next->getSlug(),
                C::NAME => $viewData?->next->name,
            ] : null,
        ];

    }

    private function formatOrigines(FeatPageView $viewData): string
    {
        if ($viewData->origins === null) {
            return '';
        }
        $html = '';
        foreach ($viewData->origins as $slug => $value) {
            $html .= Html::getDiv(
                Html::getLink(
                    $value,
                    UrlGenerator::origin($slug),
                    B::TEXT_WHITE
                ),
                [C::CSSCLASS => implode(' ', [B::BADGE, B::BG_DARK])]
            ) . ' ';
        }
        return $html;
    }

    private function formatFeatType(FeatPageView $viewData): string
    {
        switch ($viewData->feat->featTypeId) {
            case 1:
                $featType = Html::getLink(
                    L::ORIGIN_FEAT,
                    UrlGenerator::feats(C::ORIGIN),
                    B::TEXT_DARK
                );
                break;
            case 2:
                $featType = Html::getLink(
                    L::GENERAL_FEAT,
                    UrlGenerator::feats(C::GENERAL),
                    B::TEXT_DARK
                ) . C::PREREQUIS_NIV4;
                $strPreRequis = $this->wpPostService->getField(C::PREREQUIS);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType  = Html::getLink(
                    L::CBT_STYLE_FEAT,
                    UrlGenerator::feats(C::COMBAT),
                    B::TEXT_DARK
                ) . C::PREREQUIS_ASDC;
                break;
            case 4:
                $featType  = Html::getLink(
                    L::CBT_STYLE_EPIC,
                    UrlGenerator::feats(C::EPIC),
                    B::TEXT_DARK
                ) . C::PREREQUIS_NIV19;
                $strPreRequis  = $this->wpPostService->getField(C::PREREQUIS);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            default:
                $featType  = 'Don non identifié';
                break;
        }
        return $featType;
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
