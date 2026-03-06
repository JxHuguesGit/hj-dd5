<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageOrigines extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::ORIGINES,
            'icon'                    => I::USERS,
            C::TITLE       => L::HISTO_TITLE,
            C::DESCRIPTION => "L'historique de votre personnage est un ensemble d'éléments disparates qui symbolisent le lieu et l'occupation de votre héros en herbe avant qu'il embrasse la carrière d'aventurier.",
            'url'                     => Routes::ORIGINS_PREFIX,
            'order'                   => 40,
            C::PARENT      => C::HOME,
        ];
    }
}
