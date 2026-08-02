<?php
namespace src\Presenter\ViewModel;

final class SpeciesGroup
{
    public function __construct(
        public string $label,
        public string $slug,
        /** @var SpeciesRow[] */
        public array $rows
    ) {}
}
