<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsOrigin extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => 'feats-origin',
            'icon'                    => I::SCROLL,
            C::TITLE       => L::ORIGIN_FEATS,
            C::DESCRIPTION => "Les dons d'origine liés aux historiques de personnage.",
            'url'                     => Routes::FEAT_PREFIX . '-' . C::ORIGIN,
            'order'                   => 41,
            C::PARENT      => C::FEATS,
        ];
    }
}
