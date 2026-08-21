<?php
namespace src\Service\Domain;

use src\Domain\Entity\MapToken;
use src\Service\Reader\MapTokenReader;

final class MapTokenService
{
    public function __construct(
        private MapTokenReader $mapTokenReader,
    ) {}

    public function buildTokens(int $mapId): array
    {
        $tokens = [];

        /** @var MapToken $token */
        foreach ($this->mapTokenReader->mapTokensByMap($mapId) as $token) {

            $tokens[] = [
                'id' => $token->id,
                'column' => $token->column,
                'row' => $token->row,
                'size' => $token->size,
                'image' => PLUGINS_DD5 . '/assets/map/tokens/' . $token->image,
                'number' => $token->number,
                'enablePjMove' => $token->enablePjMove,
                'active' => $token->active,
            ];
        }

        return $tokens;
    }
}
