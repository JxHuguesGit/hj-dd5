<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;

class OriginListPresenter
{
    /**
     * Transforme la collection d'origines en tableau prêt à être rendu par la Page.
     */
    public function present(Collection $origins): array
    {
        return [
            Constant::CST_ITEMS => $origins
        ];
    }
}
