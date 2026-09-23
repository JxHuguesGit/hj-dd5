<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Entity\Spell;
use src\Presenter\ViewModel\SpellRow;
use src\Utils\UrlGenerator;

final class SpellListPresenter
{
    /** @param Collection<Spell> $spells */
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
            niveau: $spell->level,
            ecole: $spell->schoolName,
            classes: [],//$spell->classes,
            rituel: $spell->rituel,
            tpsInc: $spell->castingTimeName,
            portee: $spell->rangeName,
            duree: $spell->durationName,
            concentration: $spell->concentration,
            composantes: $spell->components,
            composanteMaterielle: $spell->materialComponentName,
            sourceCode: $spell->sourceCode,
        );
    }
}

