<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageFeatsEpic extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => 'feats-epic',
            'icon'                    => Icon::ISTAR,
            Constant::CST_TITLE       => Language::LG_CBT_STYLE_EPICS,
            Constant::CST_DESCRIPTION => 'Les dons de haut niveau, puissants et rares.',
            'url'                     => Routes::FEAT_PREFIX.'-'.Constant::EPIC,
            'order'                   => 44,
            Constant::CST_PARENT      => Constant::FEATS,
        ];
    }
}
