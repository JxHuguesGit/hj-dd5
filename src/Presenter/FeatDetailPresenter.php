<?php
namespace src\Presenter;

use src\Collection\Collection;
use src\Domain\Feat as DomainFeat;

class FeatDetailPresenter
{
    public function present(
        DomainFeat $feat,
        ?DomainFeat $prev,
        ?DomainFeat $next,
    ): array {
        $wpPost = get_post($feat->postId);
        $strContent = $wpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);


        switch ($feat->featTypeId) {
            case 1:
                $featType = '<a href="/feats-origin" class="text-black">Don d\'origines</a>';
                break;
            case 2:
                $featType = '<a href="/feats-general" class="text-black">Don général</a> (prérequis : niveau 4 ou supérieur';
                $strPreRequis = get_field('prerequis', $wpPost->ID);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType = '<a href="/feats-combat" class="text-black">Don de Style de combat</a> (prérequis : aptitude Style de combat)';
                break;
            case 4:
                $featType = '<a href="/feats-epic" class="text-black">Don de faveur épique</a> (prérequis : niveau 19 ou supérieur';
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
