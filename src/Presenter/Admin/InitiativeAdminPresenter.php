<?php
namespace src\Presenter\Admin;

use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Collection\Collection;
use src\Domain\Entity\Map;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class InitiativeAdminPresenter
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function present(Map $map, Collection $mapTokens, Collection $initiatives): string
    {
        $mapTokensFormatted = $this->presentMapTokens($mapTokens, $initiatives);
        $initiativesFormatted = 'wip initiativesFormatted';

        return $this->renderer->render(
            T::ADMINTIMELINE,
            [
                htmlspecialchars($map->name, ENT_QUOTES),
                UrlGenerator::admin('map', 'maps'),
                UrlGenerator::admin('map', 'maps', '', '', ['mapId' => $map->id]),
                $mapTokensFormatted,
                $initiativesFormatted
            ]
        );
    }

    private function presentMapTokens(
        Collection $mapTokens,
        Collection $initiatives
    ): string {
        $initiativeTokenIds = [];

        foreach ($initiatives as $initiative) {
            $initiativeTokenIds[] = $initiative->mapTokenId;
        }

        $html = '';

        foreach ($mapTokens as $mapToken) {
            $isInInitiative = in_array(
                $mapToken->id,
                $initiativeTokenIds,
                true
            );

            $html .= '<tr>' .
            // Visuel du token
            Html::getBalise(
                H::BALISE_TD,
                Html::getBalise(
                    H::BALISE_IMG,
                    '',
                    [
                        C::CSSCLASS => 'map-token-image',
                        'src' => PLUGINS_DD5 . 'assets/map/tokens/' . htmlspecialchars($mapToken->image, ENT_QUOTES)
                    ]
                )
            ) .
            // Position
            Html::getBalise(
                H::BALISE_TD,
                $mapToken->column . ', ' . $mapToken->row
            ) .
            // Numéro
            Html::getBalise(
                H::BALISE_TD,
                $mapToken->number
            ) .
            // Action
            Html::getBalise(
                H::BALISE_TD,
                Html::getButton(
                    Html::getIcon(I::MINUS) . Html::getIcon(I::PLUS),
                    [
                        C::CSSCLASS => 'btn btn-sm ' . ($isInInitiative ? 'btn-danger' : 'btn-success'),
                        C::TITLE => ($isInInitiative ? 'Retirer' : 'Ajouter') . ' de l\'initiative',
                    ]
                ),
                [
                    C::CSSCLASS => 'map-token' . ($isInInitiative ? ' inactive' : '')
                ]
            );
        }

        return $html;
    }
}
