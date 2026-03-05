<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsCombat extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => 'feats-combat',
            'icon'                    => I::SHIELD,
            Constant::CST_TITLE       => L::CBT_STYLE_FEATS,
            Constant::CST_DESCRIPTION => 'Les dons spécifiques aux styles de combat des guerriers.',
            'url'                     => Routes::FEAT_PREFIX . '-' . Constant::COMBAT,
            'order'                   => 43,
            Constant::CST_PARENT      => Constant::FEATS,
        ];
    }
}
