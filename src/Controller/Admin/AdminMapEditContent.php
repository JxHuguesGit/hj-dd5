<?php
namespace src\Controller\Admin;

use src\Constant\Constant as C;
use src\Domain\Entity\Map;
use src\Presenter\FormBuilder\MapFormBuilder;
use src\Utils\UrlGenerator;

final class AdminMapEditContent
{
    public function __construct(
        private MapFormBuilder $mapFormBuilder,
    ) {}

    public function getContent(Map $map): string
    {
        $hrefAction = UrlGenerator::admin('map', 'editMap', '', '', ['mapId' => $map->id]);
        $hrefCancel = UrlGenerator::admin('map', 'maps');

        $form = $this->mapFormBuilder->build($map, [
            C::TITLE => 'Édition',
            C::TYPE => C::EDIT,
            C::ACTION => $hrefAction,
            'cancelUrl' => $hrefCancel,
        ]);

        return $form->display();
    }
}
