<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageSkills extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::SKILLS,
            'icon'                    => I::STAR,
            C::TITLE       => L::SKILLS_TITLE,
            C::DESCRIPTION => "Les compétences sont des aptitudes liées aux caractéristiques qui permettent d'accomplir certaines actions spécifiques.",
            'url'                     => Routes::SKILLS_PREFIX,
            'order'                   => 10,
            C::PARENT      => C::HOME,
        ];
    }

}
