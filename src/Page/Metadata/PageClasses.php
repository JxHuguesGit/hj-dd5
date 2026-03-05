<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageClasses extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::CLASSES,
            'icon'                    => I::SHIELD,
            Constant::TITLE       => L::CLASSES,
            Constant::DESCRIPTION => 'Découvrez les classes jouables.',
            'url'                     => Routes::CLASSES_PREFIX,
            'order'                   => 30,
        ];
    }
}
