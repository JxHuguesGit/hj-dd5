<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language;
use src\Constant\Routes;

class PageFeatsOrigin extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => 'feats-origin',
            'icon'                    => I::SCROLL,
            Constant::CST_TITLE       => Language::LG_ORIGIN_FEATS,
            Constant::CST_DESCRIPTION => "Les dons d'origine liés aux historiques de personnage.",
            'url'                     => Routes::FEAT_PREFIX . '-' . Constant::ORIGIN,
            'order'                   => 41,
            Constant::CST_PARENT      => Constant::FEATS,
        ];
    }
}
