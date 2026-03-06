<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageSpecies extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::SPECIES,
            'icon'                    => I::PAW,
            C::TITLE       => L::SPECIES_TITLE,
            C::DESCRIPTION => "Les peuples du multivers de D&D proviennent de mondes très différents et comprennent maintes formes de vie intelligentes. L'espèce d'un personnage-joueur est l'ensemble des traits de jeu que l'aventurier reçoit en choisissant d'incarner l'une ou l'autre de ces formes de vie.",
            'url'                     => Routes::SPECIES_PREFIX,
            'order'                   => 30,
            C::PARENT      => C::HOME,
        ];
    }

}
