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
            niveau: $spell->level ?? 0,
            ecole: $spell->schoolName ?? '',
            classes: $spell->classes ?? [],
            rituel: $spell->rituel ?? false,
            tpsInc: $spell->castingTimeName ?? '',
            portee: $spell->rangeName ?? '',
            duree: $spell->durationName ?? '',
            concentration: $spell->concentration ?? false,
            composantes: $spell->components ?? '',
            composanteMaterielle: $spell->materialComponentName ?? '',
            description: $spell->description ?? '',
            source: $spell->sourceName ?? '',
        );
    }
}
