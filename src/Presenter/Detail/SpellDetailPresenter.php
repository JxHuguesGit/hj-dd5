<?php
namespace src\Presenter\Detail;

use src\Domain\Entity\Spell;
use src\Presenter\ViewModel\SpellDetail;
use src\Utils\UrlGenerator;

class SpellDetailPresenter
{
    public function present(
        Spell $spell
    ): SpellDetail {
        return new SpellDetail(
            name: $spell->name,
            url: UrlGenerator::spell($spell->getSlug()),
            niveau: $spell->niveau,
            ecole: $spell->ecole,
            classes: $spell->classes,
            rituel: $spell->rituel,
            tpsInc: $spell->tempsIncantation,
            portee: $spell->portee,
            duree: $spell->duree,
            concentration: $spell->concentration,
            composantes: $spell->composantes,
            composanteMaterielle: $spell->composanteMaterielle,
            description: $spell->content,
            // Source n'existe pas encore dans le moteur Wordpress
            source: '',
        );
    }
}
