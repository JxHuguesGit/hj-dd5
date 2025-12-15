<?php
namespace src\Presenter;

use src\Collection\Collection;
use src\Domain\RpgOrigin;

class OriginListPresenter
{
    /**
     * Transforme la collection d'origines en tableau prêt à être rendu par la Page.
     */
    public function present(Collection $origins): array
    {
        return [
            'origins' => $origins
        ];
    }
}
