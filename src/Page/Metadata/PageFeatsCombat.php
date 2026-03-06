<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsCombat extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => 'feats-combat',
            'icon'                    => I::SHIELD,
            C::TITLE       => L::CBT_STYLE_FEATS,
            C::DESCRIPTION => 'Les dons spécifiques aux styles de combat des guerriers.',
            'url'                     => Routes::FEAT_PREFIX . '-' . C::COMBAT,
            'order'                   => 43,
            C::PARENT      => C::FEATS,
        ];
    }
}
