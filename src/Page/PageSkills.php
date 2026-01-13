<?php
namespace src\Page;

use src\Constant\Routes;
use src\Model\PageElement;

class PageSkills
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'skills',
            'icon' => 'fa-solid fa-star',
            'title' => 'Compétences',
            'description' => "Les compétences sont des aptitudes liées aux caractéristiques qui permettent d'accomplir certaines actions spécifiques.",
            'url' => Routes::SKILLS_PREFIX,
            'order' => 10,
            'parent' => 'home',
        ]);
    }

}
