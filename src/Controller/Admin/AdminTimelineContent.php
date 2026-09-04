<?php

namespace src\Controller\Admin;

use src\Presenter\Admin\InitiativeAdminPresenter;
use src\Service\Reader\InitiativeReader;
use src\Service\Reader\MapReader;
use src\Service\Reader\MapTokenReader;

final class AdminTimelineContent implements AdminContentInterface
{
    public function __construct(
        private ?int $mapId,
        private MapReader $mapReader,
        private InitiativeReader $initiativeReader,
        private MapTokenReader $mapTokenReader,
        private InitiativeAdminPresenter $initiativeAdminPresenter,
    ) {}

    public function getContent(): string
    {
        if ($this->mapId === null) {
            return $this->initiativeAdminPresenter->presentInitiativePanel();
        }

        return $this->getTimelineContent();
    }

    private function getTimelineContent(): string
    {
        $map = $this->mapReader->mapById($this->mapId);

        $mapTokens = $this->mapTokenReader
            ->mapTokensByMap($this->mapId);

        $initiatives = $this->initiativeReader
            ->initiativesByMap($this->mapId);

        return $this->initiativeAdminPresenter->present(
            $map,
            $mapTokens,
            $initiatives
        );
    }
}
