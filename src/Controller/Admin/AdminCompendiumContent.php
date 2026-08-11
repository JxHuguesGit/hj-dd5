<?php
namespace src\Controller\Admin;

use src\Constant\Constant as C;
use src\Factory\CompendiumFactory;

final class AdminCompendiumContent implements AdminContentInterface
{
    public function __construct(
        private CompendiumFactory $compendiumFactory,
        private string $currentId,
    ) {}

    public function getContent(): string
    {
        echo "[[".$this->currentId."]]";
        return match ($this->currentId) {
            C::SKILLS => $this->compendiumFactory->skill()->render(),
            default => 'Hello Compendium !',
        };
    }
}
