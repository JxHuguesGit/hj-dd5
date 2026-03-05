<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsOrigin extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => 'feats-origin',
            'icon'                    => I::SCROLL,
            Constant::TITLE       => L::ORIGIN_FEATS,
            Constant::DESCRIPTION => "Les dons d'origine liés aux historiques de personnage.",
            'url'                     => Routes::FEAT_PREFIX . '-' . Constant::ORIGIN,
            'order'                   => 41,
            Constant::PARENT      => Constant::FEATS,
        ];
    }
}
