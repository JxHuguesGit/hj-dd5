<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeats extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::FEATS,
            'icon'                    => I::SCROLL,
            Constant::TITLE       => L::FEATS_TITLE,
            Constant::DESCRIPTION => "Les dons sont des capacités spéciales que votre personnage peut acquérir, offrant des avantages uniques et personnalisant davantage son style de jeu.",
            'url'                     => Routes::FEATS_PREFIX,
            'order'                   => 20,
            Constant::PARENT      => Constant::HOME,
        ];
    }
}
