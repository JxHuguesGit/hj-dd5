<?php
namespace src\Controller\Admin;

use src\Presenter\Admin\MapAdminPresenter;
use src\Service\Reader\MapReader;

final class AdminMapContent implements AdminContentInterface
{
    public function __construct(
        private ?int $mapId,
        private MapReader $mapReader,
        private MapAdminPresenter $mapAdminPresenter,
        private AdminMapAdministration $administration,
        private AdminMapView $mapView,
    ) {}

    public function getContent(): string
    {
        if ($this->mapId === null) {
            return $this->getMapHomeContent();
        } else {
            return $this->getMapContent();
        }
    }

    private function getMapHomeContent(): string
    {
        return $this->mapAdminPresenter->presentHome(
            $this->mapReader->allMaps()
        );
    }

    private function getMapContent(): string
    {
        $map = $this->mapReader->mapById($this->mapId);
        if (!$map) {
            return '<p>Carte introuvable.</p>';
        }

        $administration = $this->administration->getMapList($this->mapId);
        $view = $this->mapView->getContent(
            map: $map,
            tokens: $this->administration->getTokens($this->mapId),
        );

        return sprintf(
            '<div class="row">
                <div class="col-md-6">%s</div>
                <div class="col-md-6">%s</div>
            </div>',
            $administration,
            $view
        );
    }
}
