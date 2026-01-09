<?php
namespace src\Presenter;

use src\Collection\Collection;
use src\Domain\Specie as DomainSpecies;

class SpeciesDetailPresenter
{
    public function present(
        DomainSpecies $species,
        ?DomainSpecies $prev,
        ?DomainSpecies $next,
    ): array {
        $wpPost = get_post($species->postId);
        $strContent = $wpPost->post_content;

        return [
            'title' => $species->name,
            'slug'  => $species->getSlug(),

            'description' => $strContent,
            'creatureType' => get_field('type_de_creature', $wpPost->ID),
            'sizeCategory' => get_field('categorie_de_taille', $wpPost->ID),
            'speed' => get_field('vitesse', $wpPost->ID),
            'powers' => '',

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
