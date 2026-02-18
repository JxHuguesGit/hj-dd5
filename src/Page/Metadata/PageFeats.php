<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageFeats extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::FEATS,
            'icon'                    => Icon::ISCROLL,
            Constant::CST_TITLE       => Language::LG_FEATS,
            Constant::CST_DESCRIPTION => "Les dons sont des capacités spéciales que votre personnage peut acquérir, offrant des avantages uniques et personnalisant davantage son style de jeu.",
            'url'                     => Routes::FEATS_PREFIX,
            'order'                   => 20,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }
}
