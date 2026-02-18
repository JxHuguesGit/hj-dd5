<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageFeatsGeneral extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => 'feats-general',
            'icon'                    => Icon::ISCROLL,
            Constant::CST_TITLE       => Language::LG_GENERAL_FEATS,
            Constant::CST_DESCRIPTION => "Les dons accessibles au cours de la carrière d'un personnage.",
            'url'                     => Routes::FEAT_PREFIX.'-'.Constant::GENERAL,
            'order'                   => 42,
            Constant::CST_PARENT      => Constant::FEATS,
        ];
    }
}
