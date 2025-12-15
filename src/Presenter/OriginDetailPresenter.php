<?php
namespace src\Presenter;

use src\Entity\RpgFeat;
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
    ): array {
        // Capacités
        $abilities = [];
        /*
        foreach ($origin->getOriginAbilities() as $originAbility) {
            $abilities[] = $originAbility->getAbility()->getName();
        }
        */

        // Compétences
        $skills = [];
        /*
        foreach ($origin->getOriginSkills() as $originSkill) {
            $skills[] = $originSkill->getSkill()->getName();
        }
        */

        $strContent = '';//$origin->getWpPost()->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);
        $strEquipment = '';//get_field('equipement', $this->origin->getWpPost()->ID);

        return [
            'title' => $origin->name,
            'slug'  => $origin->getSlug(),

            'abilities' => $abilities,
            'skills'    => $skills,

            'description' => $strContent,
            'originFeat' => $rpgFeat->getName(),
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
