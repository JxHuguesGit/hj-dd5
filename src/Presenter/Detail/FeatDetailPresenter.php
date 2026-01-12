<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Presenter\ViewModel\FeatPageView;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class FeatDetailPresenter
{
    public function present(
        FeatPageView $viewData
    ): array {
        $wpPostService = new WpPostService();
        $wpPost = $wpPostService->getById($viewData->feat->postId);
        $strContent = $wpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);


        switch ($viewData->feat->featTypeId) {
            case 1:
                $featType = Html::getLink(
                    Language::LG_ORIGIN_FEAT,
                    UrlGenerator::feats(Constant::ORIGIN),
                    Bootstrap::CSS_TEXT_DARK
                );
                break;
            case 2:
                $featType = Html::getLink(
                    Language::LG_GENERAL_FEAT,
                    UrlGenerator::feats(Constant::GENERAL),
                    Bootstrap::CSS_TEXT_DARK
                );
                $featType .= Constant::CST_PREREQUIS_NIV4;
                $strPreRequis = $wpPostService->getField(Constant::CST_PREREQUIS);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType = Html::getLink(
                    Language::LG_CBT_STYLE_FEAT,
                    UrlGenerator::feats(Constant::COMBAT),
                    Bootstrap::CSS_TEXT_DARK
                )
                . Constant::CST_PREREQUIS_ASDC;
                break;
            case 4:
                $featType = Html::getLink(
                    Language::LG_CBT_STYLE_EPIC,
                    UrlGenerator::feats(Constant::EPIC),
                    Bootstrap::CSS_TEXT_DARK
                );
                $featType .= Constant::CST_PREREQUIS_NIV19;
                $strPreRequis = $wpPostService->getField(Constant::CST_PREREQUIS);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            default:
                $featType = 'Don non identifié';
                break;
        }

        return [
            Constant::CST_TITLE => $viewData->feat->name,
            Constant::CST_SLUG  => $viewData->feat->getSlug(),

            Constant::CST_DESCRIPTION => $strContent,

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
                Constant::CST_NAME => $viewData?->previous->name,
            ] : null,

            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_SLUG => $viewData?->next->getSlug(),
                Constant::CST_NAME => $viewData?->next->name,
            ] : null,
            Constant::CST_FEATTYPE => $featType
        ];
        
    }
}
