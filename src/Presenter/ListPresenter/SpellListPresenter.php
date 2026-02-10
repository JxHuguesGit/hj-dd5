<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Entity\Spell;
use src\Presenter\ViewModel\SpellRow;
use src\Utils\UrlGenerator;

final class SpellListPresenter
{
    public function present(iterable $spells): Collection
    {
        $collection = new Collection();
        foreach ($spells as $spell) {
            $collection->add($this->buildRow($spell));
        }

        return $collection;
    }

    private function buildRow(Spell $spell): SpellRow
    {
        return new SpellRow(
            name: $spell->name,
            url: UrlGenerator::spell($spell->slug),
            niveau: $spell->niveau,
            ecole: mb_ucfirst($spell->ecole),
            classes: $spell->classes,
            rituel: $spell->rituel,
            tpsInc: $spell->tempsIncantation,
            portee: $spell->portee,
            duree: $spell->duree,
            concentration: $spell->concentration,
            composantes: $spell->composantes,
            composanteMaterielle: $spell->composanteMaterielle
        );
    }
}

