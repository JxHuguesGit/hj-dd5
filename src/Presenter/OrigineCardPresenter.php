<?php
namespace src\Presenter;

use src\Constant\Template;
use src\Controller\Utilities;

class OrigineCardPresenter
{
    private array $origines;

    public function __construct(array $origines)
    {
        $this->origines = $origines;
    }

    public function render(): string
    {
        $utilities = new Utilities();
        $html = '';
        foreach ($this->origines as $origine) {
            $attributes = [
                'url' => $origine['url'],
                'src' => $origine['image'],
                'title' => $origine['title'],
                'showImage' => 'd-none',
                'icon' => $origine['icon'],
                'description' => $origine['description'],
            ];
            $html .= $utilities->getRender(Template::ORIGIN_CARD, $attributes);
        }
        return $html;
    }
}
