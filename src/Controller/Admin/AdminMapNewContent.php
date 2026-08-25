<?php
namespace src\Controller\Admin;

use src\Constant\Constant as C;
use src\Domain\Entity\Map;
use src\Presenter\FormBuilder\MapFormBuilder;
use src\Utils\UrlGenerator;

final class AdminMapNewContent
{
    public function __construct(
        private MapFormBuilder $mapFormBuilder,
    ) {}

    public function getContent(): string
    {
        $map = new Map();
        $hrefAction = UrlGenerator::admin('map', 'newMap');
        $hrefCancel = UrlGenerator::admin('map', 'maps');

        $form = $this->mapFormBuilder->build($map, [
            C::TITLE => 'Création',
            C::TYPE => C::NEW,
            C::ACTION => $hrefAction,
            'cancelUrl' => $hrefCancel,
        ]);

        return $form->display();
    }
}
