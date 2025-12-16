<?php
namespace src\Presenter;

use src\Collection\Collection;
use src\Domain\RpgFeat;
use src\Domain\RpgOrigin;
use src\Entity\RpgTool;

class OriginDetailPresenter
{
    public function present(
        RpgOrigin $origin,
        ?RpgOrigin $prev,
        ?RpgOrigin $next,
        ?RpgFeat $rpgFeat,
        ?RpgTool $rpgTool,
        Collection $originAbilities,
        Collection $originSkills
    ): array {
        // Capacités
        $abilities = [];
        foreach ($originAbilities as $ability) {
            $abilities[] = $ability->name;
        }

        // Compétences
        $skills = [];
        foreach ($originSkills as $skill) {
            $skills[] = $skill->name;
        }

        $wpPost = get_post($origin->postId);
        $strContent = $wpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);
        $strEquipment = get_field('equipement', $wpPost->ID);

        return [
            'title' => $origin->name,
            'slug'  => $origin->getSlug(),

            'abilities' => $abilities,
            'skills'    => $skills,

            'description' => $strContent,
            'originFeat' => $rpgFeat->name,
            'originTool' => $rpgTool->getName(),
            'originEquipment' => $strEquipment,

            'prev' => $prev ? [
                'slug' => $prev->getSlug(),
                'name' => $prev->name,
            ] : null,

            'next' => $next ? [
                'slug' => $next->getSlug(),
                'name' => $next->name,
            ] : null,
        ];
    }
}
