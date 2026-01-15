<?php
namespace src\Presenter\ViewModel;

final class SpeciesRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $creatureType,
        public string $sizeCategory,
        public string $speed
    ) {}
}
