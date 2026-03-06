<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageClasses extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::CSSCLASSES,
            'icon'                    => I::SHIELD,
            C::TITLE       => L::CLASSES,
            C::DESCRIPTION => 'Découvrez les classes jouables.',
            'url'                     => Routes::CLASSES_PREFIX,
            'order'                   => 30,
        ];
    }
}
