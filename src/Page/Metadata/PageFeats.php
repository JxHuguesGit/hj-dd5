<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeats extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::FEATS,
            'icon'                    => I::SCROLL,
            C::TITLE       => L::FEATS_TITLE,
            C::DESCRIPTION => "Les dons sont des capacités spéciales que votre personnage peut acquérir, offrant des avantages uniques et personnalisant davantage son style de jeu.",
            'url'                     => Routes::FEATS_PREFIX,
            'order'                   => 20,
            C::PARENT      => C::HOME,
        ];
    }
}
