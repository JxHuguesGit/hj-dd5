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
        return match ($this->currentId) {
            C::SKILLS => $this->compendiumFactory->skill()->render(),
            C::FEATS => $this->compendiumFactory->feat()->render(),
            default => 'Hello Compendium !',
        };
    }
}
