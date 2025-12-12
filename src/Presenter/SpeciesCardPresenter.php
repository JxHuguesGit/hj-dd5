<?php
namespace src\Presenter;

use src\Constant\Template;
use src\Controller\Utilities;

class SpeciesCardPresenter
{
    private array $species;

    public function __construct(array $species)
    {
        $this->species = $species;
    }

    public function render(): string
    {
        $utilities = new Utilities();
        $html = '';
        foreach ($this->species as $specie) {
            $attributes = [
                'url' => $specie['url'],
                'src' => $specie['image'],
                'title' => $specie['title'],
                'showImage' => 'd-none',
                'icon' => $specie['icon'],
                'description' => $specie['description'],
            ];
            $html .= $utilities->getRender(Template::ORIGIN_CARD, $attributes);
        }
        return $html;
    }
}
