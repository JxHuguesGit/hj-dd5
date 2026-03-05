<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language;
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
            Constant::CST_TITLE       => $viewData->feat->name,
            Constant::CST_SLUG        => $viewData->feat->getSlug(),

            Constant::CST_DESCRIPTION => $this->cleanContent($wpPost->post_content ?? ''),
            Constant::CST_FEATTYPE    => $this->formatFeatType($viewData),

            Constant::ORIGINES        => $this->formatOrigines($viewData),

            Constant::CST_PREV        => $viewData->previous ? [
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
                Constant::CST_NAME => $viewData?->previous->name,
            ] : null,

            Constant::CST_NEXT        => $viewData->next ? [
                Constant::CST_SLUG => $viewData?->next->getSlug(),
                Constant::CST_NAME => $viewData?->next->name,
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
                [Constant::CST_CLASS => implode(' ', [B::BADGE, B::BG_DARK])]
            ) . ' ';
        }
        return $html;
    }

    private function formatFeatType(FeatPageView $viewData): string
    {
        switch ($viewData->feat->featTypeId) {
            case 1:
                $featType = Html::getLink(
                    Language::LG_ORIGIN_FEAT,
                    UrlGenerator::feats(Constant::ORIGIN),
                    B::TEXT_DARK
                );
                break;
            case 2:
                $featType = Html::getLink(
                    Language::LG_GENERAL_FEAT,
                    UrlGenerator::feats(Constant::GENERAL),
                    B::TEXT_DARK
                ) . Constant::CST_PREREQUIS_NIV4;
                $strPreRequis = $this->wpPostService->getField(Constant::CST_PREREQUIS);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType  = Html::getLink(
                    Language::LG_CBT_STYLE_FEAT,
                    UrlGenerator::feats(Constant::COMBAT),
                    B::TEXT_DARK
                ) . Constant::CST_PREREQUIS_ASDC;
                break;
            case 4:
                $featType  = Html::getLink(
                    Language::LG_CBT_STYLE_EPIC,
                    UrlGenerator::feats(Constant::EPIC),
                    B::TEXT_DARK
                ) . Constant::CST_PREREQUIS_NIV19;
                $strPreRequis  = $this->wpPostService->getField(Constant::CST_PREREQUIS);
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
