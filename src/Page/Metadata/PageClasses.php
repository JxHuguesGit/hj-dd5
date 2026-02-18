<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageClasses extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::CLASSES,
            'icon'                    => Icon::ISHIELD,
            Constant::CST_TITLE       => Language::LG_CLASSES,
            Constant::CST_DESCRIPTION => 'Découvrez les classes jouables.',
            'url'                     => Routes::CLASSES_PREFIX,
            'order'                   => 30,
        ];
    }
}
