<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageFeatsEpic extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => 'feats-epic',
            'icon'                    => I::STAR,
            C::TITLE       => L::CBT_STYLE_EPICS,
            C::DESCRIPTION => 'Les dons de haut niveau, puissants et rares.',
            'url'                     => Routes::FEAT_PREFIX . '-' . C::EPIC,
            'order'                   => 44,
            C::PARENT      => C::FEATS,
        ];
    }
}
