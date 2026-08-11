<?php
namespace src\Presenter\Admin;

use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Domain\Entity\Map;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;

final class MapTokenAdminPresenter
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function present(array $tokens, Map $map): string
    {
        $rows = '';

        foreach ($tokens as $token) {
            $strImage = Html::getBalise(
                H::BALISE_IMG,
                '',
                [
                    'src' => $token['image'],
                    'alt' => '',
                    C::CSSCLASS => 'map-token-image'
                ]
            );
            $btnAttributes = [
                C::CSSCLASS => 'btn-danger ajaxAction',
                C::TITLE    => 'Supprimer le token',
                C::DATA     => [
                    C::TRIGGER => C::CLICK,
                    C::ACTION  => 'deleteMapToken',
                    'map-token-id' => $token['id']
                ]
            ];
            if ($map->locked) {
                $btnAttributes[C::DISABLED] = C::DISABLED;
            }
            $strButton = Html::getButton(
                Html::getIcon(I::TRASHALT),
                $btnAttributes
            );

            $row =
                Html::getBalise(H::BALISE_TD, $strImage) .
                Html::getBalise(H::BALISE_TD, $token['column'], [C::CSSCLASS => 'map-token-column']) .
                Html::getBalise(H::BALISE_TD, $token['row'], [C::CSSCLASS => 'map-token-row']) .
                Html::getBalise(H::BALISE_TD, $token['size']) .
                Html::getBalise(H::BALISE_TD, $token['number'] ?? '') .
                Html::getBalise(H::BALISE_TD, $strButton, [C::CSSCLASS => 'map-token-actions']);

            $rows .= Html::getBalise(H::BALISE_TR, $row, [C::CSSCLASS => 'map-token', C::DATA => ['token-id' => $token['id']]]);
        }

        return $this->renderer->render(
            T::ADMINMAPTOKTABLE,
            [
                $map->locked ? ' disabled' : '',
                $rows
            ]
        );

    }
}

