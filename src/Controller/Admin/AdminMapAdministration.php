<?php
namespace src\Controller\Admin;

use src\Presenter\Admin\MapTokenAdminPresenter;
use src\Presenter\Admin\TokenAdminPresenter;
use src\Service\Domain\MapTokenService;
use src\Service\Reader\MapReader;
use src\Service\Reader\TokenReader;

final class AdminMapAdministration implements AdminContentInterface
{
    public function __construct(
        private MapTokenService $mapTokenService,
        private MapTokenAdminPresenter $presenter,
        private TokenReader $tokenReader,
        private TokenAdminPresenter $tokenAdminPresenter,
        private MapReader $mapReader,
    ) {}

    public function getContent(): string
    {
        return '';
    }

    public function getTokens(int $mapId): array
    {
        return $this->mapTokenService->buildTokens($mapId);
    }

    public function getMapList(int $mapId): string
    {
        $tokens = $this->mapTokenService->buildTokens($mapId);
        $map = $this->mapReader->mapById($mapId);

        return $this->presenter->present($tokens, $map);
    }

    public function getAddMapTokenModal(): string
    {
        return $this->tokenAdminPresenter->presentAddModal(
            $this->tokenReader->activeTokens()
        );
    }
}
