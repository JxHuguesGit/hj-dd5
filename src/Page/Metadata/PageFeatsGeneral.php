<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsGeneral extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => 'feats-general',
            'icon'                    => I::SCROLL,
            Constant::TITLE       => L::GENERAL_FEATS,
            Constant::DESCRIPTION => "Les dons accessibles au cours de la carrière d'un personnage.",
            'url'                     => Routes::FEAT_PREFIX . '-' . Constant::GENERAL,
            'order'                   => 42,
            Constant::PARENT      => Constant::FEATS,
        ];
    }
}
