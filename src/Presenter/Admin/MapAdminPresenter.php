<?php
namespace src\Presenter\Admin;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Collection\Collection;
use src\Domain\Entity\Map;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;

final class MapAdminPresenter
{
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
            $href = '/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=map&mapId=' . $map->id;

            $btnActivateAttributes = [
                C::CSSCLASS => 'btn-primary ajaxAction',
                C::DATA     => [
                    C::TRIGGER  => C::CLICK,
                    C::ACTION   => 'activateMap',
                    'map-id'    => $map->id
                ],
            ];
            if ($map->active) {
                $btnActivateAttributes[C::DISABLED] = C::DISABLED;
            }

            $lockLabel = Html::getIcon($map->locked ? I::UNLOCK : I::LOCK) . ' ' . ($map->locked ? 'Déverrouiller' : 'Verrouiller');
            $btnLockAttributes = [
                C::CSSCLASS => 'btn-primary ajaxAction',
                C::DATA     => [
                    C::TRIGGER  => C::CLICK,
                    C::ACTION   => $map->locked ? 'unlockMap' : 'lockMap',
                    'map-id'    => $map->id
                ],
            ];
            $cardContent =
                Html::getLink('Ouvrir', $href, 'btn btn-sm btn-primary') . ' ' .
                Html::getButton('Activer', $btnActivateAttributes) . ' ' .
                Html::getButton($lockLabel, $btnLockAttributes)
            ;

            $attributes = [
                htmlspecialchars($map->name),
                $map->mapColumns,
                $map->mapRows,
                $cardContent
            ];

            $strMaps .= $this->renderer->render(
                T::MAP_CARD,
                $attributes
            );
        }

        return Html::getDiv($strMaps, [C::CSSCLASS => 'row g-3']);
    }
}
