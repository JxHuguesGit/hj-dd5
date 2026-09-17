<?php
namespace src\Presenter\Detail;

use src\Domain\Entity\Spell;
use src\Presenter\ViewModel\SpellDetail;
use src\Utils\UrlGenerator;

class SpellDetailPresenter
{
    public function present(
        ?Spell $spell
    ): SpellDetail {
        return new SpellDetail(
            name: $spell->name ?? '',
            url: $spell ? UrlGenerator::spell($spell->slug) : '#',
            niveau: $spell->niveau ?? 0,
            ecole: $spell->ecole ?? '',
            classes: $spell->classes ?? [],
            rituel: $spell->rituel ?? false,
            tpsInc: $spell->tempsIncantation ?? '',
            portee: $spell->portee ?? '',
            duree: $spell->duree ?? '',
            concentration: $spell->concentration ?? false,
            composantes: $spell->composantes ?? [],
            composanteMaterielle: $spell->composanteMaterielle ?? '',
            description: $spell->content ?? '',
            // Source n'existe pas encore dans le moteur Wordpress
            source: '',
        );
    }
}
