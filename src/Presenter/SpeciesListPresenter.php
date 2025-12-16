<?php
namespace src\Presenter;

use src\Collection\Collection;

class SpeciesListPresenter
{
    /**
     * Transforme la collection d'espèces en tableau prêt à être rendu par la Page.
     */
    public function present(Collection $species): array
    {
        return [
            'species' => $species
        ];
    }
}
