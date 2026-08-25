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

final class MapAdminPresenter
{
    private const DEFAULT_LINK_BUTTON_CLASS = 'btn btn-sm btn-dark';

    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    /**
     * @param Collection<Map> $maps
     */
    public function presentHome(Collection $maps): string
    {
        if ($maps->isEmpty()) {
            return '<p>Aucune map disponible.</p>';
        }

        $strMaps = '';

        foreach ($maps as $map) {
            $strMaps .= $this->presentMapCard($map);
        }

        return $this->presentMapHeader()
            . Html::getDiv(
                $strMaps,
                [C::CSSCLASS => 'row g-3 mx-3']
            );
    }

    private function presentMapCard(Map $map): string
    {
        $cardContent = Html::getDiv(
            $this->presentPrimaryActions($map)
            . $this->presentSecondaryActions($map),
            [
                C::CSSCLASS => 'd-flex justify-content-between align-items-center'
            ]
        );

        return $this->renderer->render(
            T::MAP_CARD,
            [
                htmlspecialchars($map->name),
                $map->mapColumns,
                $map->mapRows,
                $cardContent
            ]
        );
    }

    private function linkButton(
        string $icon,
        string $label,
        string $url,
        string $class = self::DEFAULT_LINK_BUTTON_CLASS,
    ): string {
        return Html::getLink(
            Html::getIcon($icon) . ($label !== '' ? ' ' . $label : ''),
            $url,
            $class
        );
    }

    private function presentPrimaryActions(Map $map): string
    {
        $open = $this->linkButton(
            I::EYE,
            'Ouvrir',
            UrlGenerator::admin('map', 'maps', '', '', ['mapId' => $map->id]),
            'btn btn-sm btn-primary'
        );

        $edit = $this->linkButton(
            I::EDIT,
            'Editer',
            UrlGenerator::admin('map', 'editMap', '', '', ['mapId' => $map->id]),
            $this->disabledClass($map->locked, 'btn btn-sm btn-secondary')
        );

        return Html::getDiv(
            $open . ' '
            . $edit . ' '
            . $this->presentDeleteButton($map)
        );
    }

    private function presentDeleteButton(Map $map): string
    {
        $attributes = [
            C::CSSCLASS => 'btn btn-sm btn-danger ajaxAction',
            C::DATA => [
                C::TRIGGER => C::CLICK,
                C::ACTION => 'deleteMap',
                'map-id' => $map->id,
            ],
        ];

        if ($map->active || $map->locked) {
            $attributes[C::DISABLED] = C::DISABLED;
        }

        return Html::getBalise(
            H::BALISE_BUTTON,
            Html::getIcon(I::TRASHALT) . ' Supprimer',
            $attributes
        );
    }

    private function presentSecondaryActions(Map $map): string
    {
        return Html::getDiv(
            $this->ajaxButton(
                $map->active ? I::TOGGLEON : I::TOGGLEOFF,
                'Activer',
                'activateMap',
                $map,
                disabled: $map->active
            ) .
            $this->presentInitiativeButton($map) .
            $this->ajaxButton(
                I::ERASER,
                'Réinitialiser',
                'resetMapFog',
                $map,
                disabled: $map->locked
            ) .
            $this->ajaxButton(
                $map->locked ? I::UNLOCK : I::LOCK,
                $map->locked ? 'Déverrouiller' : 'Verrouiller',
                $map->locked ? 'unlockMap' : 'lockMap',
                $map
            ) .
            $this->ajaxButton(
                I::COPY,
                'Dupliquer',
                'duplicateMap',
                $map
            ),
            [
                C::CSSCLASS => 'btn-group',
                'role' => 'group',
            ]
        );
    }

    private function presentInitiativeButton(Map $map): string
    {
        $class = $this->disabledClass($map->locked, self::DEFAULT_LINK_BUTTON_CLASS);
        $timelineHref = UrlGenerator::admin('timeline', '', '', '', ['mapId' => $map->id]);

        return $this->linkButton(
            I::LISTOL,
            '',
            $timelineHref,
            $class
        );
    }

    private function disabledClass(bool $disabled, string $class): string
    {
        return $disabled
            ? $class . ' ' . C::DISABLED
            : $class;
    }

    private function presentMapHeader(): string
    {
        return Html::getDiv(
            Html::getBalise(
                H::BALISE_H3,
                'Maps',
                [C::CSSCLASS => 'mb-0']
            )
            . Html::getLink(
                Html::getIcon(I::PLUS) . ' Nouvelle Map',
                UrlGenerator::admin('map', 'newMap'),
                'btn btn-sm btn-primary'
            ),
            [
                C::CSSCLASS =>
                    'd-flex justify-content-between align-items-center mb-3 mx-3'
            ]
        );
    }

    private function ajaxButton(
        string $icon,
        string $title,
        string $action,
        Map $map,
        string $class = self::DEFAULT_LINK_BUTTON_CLASS,
        bool $disabled = false
    ): string {
        $attributes = [
            C::CSSCLASS => $class . ' ajaxAction',
            C::TITLE => $title,
            C::DATA => [
                C::TRIGGER => C::CLICK,
                C::ACTION => $action,
                'map-id' => $map->id,
            ],
        ];

        if ($disabled) {
            $attributes[C::DISABLED] = C::DISABLED;
        }

        return Html::getBalise(
            H::BALISE_BUTTON,
            Html::getIcon($icon),
            $attributes
        );
    }
}
