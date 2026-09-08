<?php
namespace src\Presenter\ViewModel;

final class InitiativeRow
{
    public function __construct(
        public string $name,
        public float $initiative,
        public bool $active,
        public string $type,
    ) {}
}
