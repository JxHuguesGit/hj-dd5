<?php
namespace src\Controller\Admin;

use src\Constant\Field as F;
use src\Domain\Entity\Map;
use src\Presenter\Admin\MapAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Service\Reader\MapReader;
use src\Service\Reader\TokenReader;
use src\Service\Writer\MapWriter;
use src\Utils\Session;

final class AdminMapContent implements AdminContentInterface
{
    public function __construct(
        private int|string $id,
        private ?int $mapId,
        private MapReader $mapReader,
        private MapWriter $mapWriter,
        private MapAdminPresenter $mapAdminPresenter,
        private AdminMapAdministration $administration,
        private AdminMapView $mapView,
        private AdminMapEditContent $mapEdit,
        private AdminMapNewContent $mapNew,
        private TokenReader $tokenReader,
        private TokenAdminPresenter $tokenAdminPresenter,
    ) {}

    public function getContent(): string
    {
        if (Session::isPostSubmitted()) {
            return match ($this->id) {
                'editMap' => $this->handleMapEditSubmit(),
                'newMap'  => $this->handleMapNewSubmit(),
                default   => $this->getMapContent(),
            };
        }

        if ($this->mapId !== null && $this->id === 'maps') {
            return $this->getMapContent();
        }

        return match ($this->id) {
            'maps'    => $this->getMapHomeContent(),
            'tokens'  => $this->getTokenHomeContent(),
            'editMap' => $this->getMapEditContent(),
            'newMap'  => $this->getMapNewContent(),
            default   => $this->getMapHomeContent(),
        };
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
            visibleCells: [],
            discoveredCells: [],
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

    private function getMapEditContent(): string
    {
        $map = $this->mapReader->mapById($this->mapId);
        if (!$map) {
            return '<p>Carte introuvable.</p>';
        }

        return $this->mapEdit->getContent($map);
    }

    private function getMapNewContent(): string
    {
        return $this->mapNew->getContent();
    }

    private function handleMapEditSubmit(): string
    {
        $map = $this->mapReader->mapById($this->mapId);

        if (!$map) {
            return '<p>Carte introuvable.</p>';
        }

        $changedFields = [];

        foreach (Map::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');

            if ($value !== 'err' && $map->$field != $value) {
                $map->$field = $value;
                $changedFields[] = $field;
            }
        }

        if (!empty($changedFields)) {
            $this->mapWriter->updatePartial(
                $map,
                $changedFields
            );
        }

        return $this->getMapEditContent();
    }

    private function handleMapNewSubmit(): string
    {
        $map = new Map([
            F::NAME         => Session::fromPost(F::NAME),
            F::IMAGE        => Session::fromPost(F::IMAGE),
            F::MAPCOLUMNS   => (int) Session::fromPost(F::MAPCOLUMNS),
            F::MAPROWS      => (int) Session::fromPost(F::MAPROWS),
            F::CELLSIZE     => (int) Session::fromPost(F::CELLSIZE),
            F::VISIONRANGE  => (int) Session::fromPost(F::VISIONRANGE),
            F::ACTIVE       => 0,
            F::LOCKED       => 0
        ]);

        $this->mapWriter->insert($map);

        return $this->getMapHomeContent();
    }
}
