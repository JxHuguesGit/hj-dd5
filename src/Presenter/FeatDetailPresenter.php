<?php
namespace src\Presenter;

use src\Collection\Collection;
use src\Domain\RpgFeat;

class FeatDetailPresenter
{
    public function present(
        RpgFeat $feat,
        ?RpgFeat $prev,
        ?RpgFeat $next,
    ): array {
        $wpPost = get_post($feat->postId);
        $strContent = $wpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);


        switch ($feat->featTypeId) {
            case 1:
                $featType = 'Don d\'origines';
                break;
            case 2:
                $featType = 'Don général (prérequis : niveau 4 ou supérieur';
                $strPreRequis = get_field('prerequis', $wpPost->ID);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType = 'Don de Style de combat (prérequis : aptitude Style de combat)';
                break;
            case 4:
                $featType = 'Don de faveur épique (prérequis : niveau 19 ou supérieur';
                $strPreRequis = get_field('prerequis', $wpPost->ID);
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
            'title' => $feat->name,
            'slug'  => $feat->getSlug(),
            'description' => $strContent,
            'prev' => $prev ? [
                'slug' => $prev->getSlug(),
                'name' => $prev->name,
            ] : null,

            'next' => $next ? [
                'slug' => $next->getSlug(),
                'name' => $next->name,
            ] : null,
            'featType' => $featType
        ];
    }
}
