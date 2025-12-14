<?php
namespace src\Page;

use src\Model\PageElement;

class PageSpecies
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'species',
            'icon' => 'fa-solid fa-paw',
            'title' => 'Espèces',
            'description' => "Les peuples du multivers de D&D proviennent de mondes très différents et comprennent maintes formes de vie intelligentes. L'espèce d'un personnage-joueur est l'ensemble des traits de jeu que l'aventurier reçoit en choisissant d'incarner l'une ou l'autre de ces formes de vie.",
            'url' => '/species',
            'order' => 20,
            'parent' => 'home',
        ]);
    }

}
