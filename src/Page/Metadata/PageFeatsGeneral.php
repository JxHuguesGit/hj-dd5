<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsGeneral extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => 'feats-general',
            'icon'                    => I::SCROLL,
            C::TITLE       => L::GENERAL_FEATS,
            C::DESCRIPTION => "Les dons accessibles au cours de la carrière d'un personnage.",
            'url'                     => Routes::FEAT_PREFIX . '-' . C::GENERAL,
            'order'                   => 42,
            C::PARENT      => C::FEATS,
        ];
    }
}
