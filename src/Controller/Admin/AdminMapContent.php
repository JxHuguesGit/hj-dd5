<?php
namespace src\Controller\Admin;

use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Service\Reader\MapReader;
use src\Service\Reader\TokenReader;

final class AdminMapContent implements AdminContentInterface
{
    public function __construct(
        private int|string $id,
        private ?int $mapId,
        private MapReader $mapReader,
        private MapAdminPresenter $mapAdminPresenter,
        private AdminMapAdministration $administration,
        private AdminMapView $mapView,
        private TokenReader $tokenReader,
        private TokenAdminPresenter $tokenAdminPresenter,
    ) {}

    public function getContent(): string
    {
        if ($this->mapId !== null) {
            return $this->getMapContent();
        } else {
            return match ($this->id) {
                'maps' => $this->getMapHomeContent(),
                'tokens' => $this->getTokenHomeContent(),
                default => $this->getMapHomeContent(),
            };
        }
    }

    private function getMapHomeContent(): string
    {
        return $this->mapAdminPresenter->presentHome(
            $this->mapReader->allMaps()
        );
    }

    private function getTokenHomeContent(): string
    {
        return $this->tokenAdminPresenter->present(
            $this->tokenReader->allTokens()
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
