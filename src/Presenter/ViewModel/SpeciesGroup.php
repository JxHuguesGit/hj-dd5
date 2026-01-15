<?php
namespace src\Presenter\ViewModel;

final class SpeciesGroup
{
    /**
     * @param SpeciesRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows,
        public string $extra = ''
    ) {}
}
