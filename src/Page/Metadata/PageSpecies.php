<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageSpecies extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::SPECIES,
            'icon'                    => Icon::IPAW,
            Constant::CST_TITLE       => Language::LG_SPECIES_TITLE,
            Constant::CST_DESCRIPTION => "Les peuples du multivers de D&D proviennent de mondes très différents et comprennent maintes formes de vie intelligentes. L'espèce d'un personnage-joueur est l'ensemble des traits de jeu que l'aventurier reçoit en choisissant d'incarner l'une ou l'autre de ces formes de vie.",
            'url'                     => Routes::SPECIES_PREFIX,
            'order'                   => 30,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }

}
