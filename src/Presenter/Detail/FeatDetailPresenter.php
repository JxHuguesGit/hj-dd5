<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
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
            Constant::TITLE       => $viewData->feat->name,
            Constant::SLUG        => $viewData->feat->getSlug(),

            Constant::DESCRIPTION => $this->cleanContent($wpPost->post_content ?? ''),
            Constant::FEATTYPE    => $this->formatFeatType($viewData),

            Constant::ORIGINES        => $this->formatOrigines($viewData),

            Constant::PREV        => $viewData->previous ? [
                Constant::SLUG => $viewData?->previous->getSlug(),
                Constant::NAME => $viewData?->previous->name,
            ] : null,

            Constant::NEXT        => $viewData->next ? [
                Constant::SLUG => $viewData?->next->getSlug(),
                Constant::NAME => $viewData?->next->name,
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
                [Constant::CLASS => implode(' ', [B::BADGE, B::BG_DARK])]
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
                    UrlGenerator::feats(Constant::ORIGIN),
                    B::TEXT_DARK
                );
                break;
            case 2:
                $featType = Html::getLink(
                    L::GENERAL_FEAT,
                    UrlGenerator::feats(Constant::GENERAL),
                    B::TEXT_DARK
                ) . Constant::PREREQUIS_NIV4;
                $strPreRequis = $this->wpPostService->getField(Constant::PREREQUIS);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType  = Html::getLink(
                    L::CBT_STYLE_FEAT,
                    UrlGenerator::feats(Constant::COMBAT),
                    B::TEXT_DARK
                ) . Constant::PREREQUIS_ASDC;
                break;
            case 4:
                $featType  = Html::getLink(
                    L::CBT_STYLE_EPIC,
                    UrlGenerator::feats(Constant::EPIC),
                    B::TEXT_DARK
                ) . Constant::PREREQUIS_NIV19;
                $strPreRequis  = $this->wpPostService->getField(Constant::PREREQUIS);
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
