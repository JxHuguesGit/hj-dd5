<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;

class SpeciesListPresenter
{
    /**
     * Transforme la collection d'espèces en tableau prêt à être rendu par la Page.
     */
    public function present(Collection $species): array
    {
        return [
            Constant::CST_ITEMS => $species
        ];
    }
}
