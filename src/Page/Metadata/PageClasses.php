<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language;
use src\Constant\Routes;

class PageClasses extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::CLASSES,
            'icon'                    => I::SHIELD,
            Constant::CST_TITLE       => Language::LG_CLASSES,
            Constant::CST_DESCRIPTION => 'Découvrez les classes jouables.',
            'url'                     => Routes::CLASSES_PREFIX,
            'order'                   => 30,
        ];
    }
}
