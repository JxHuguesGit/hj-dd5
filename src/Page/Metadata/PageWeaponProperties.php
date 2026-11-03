<?php

namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Routes;

class PageWeaponProperties extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => 'proprietes-darmes',
            'icon'         => I::BOOK,
            C::TITLE       => 'Propriétés d\'armes',
            C::DESCRIPTION => 'Liste des propriétés d\'armes.',
            'url'          => Routes::RULES_PREFIX . Routes::WPNPROPERTIES_PREFIX,
            'order'        => 73,
            C::PARENT      => C::RULES,
            'adminOnly'    => true,
        ];
    }
}
