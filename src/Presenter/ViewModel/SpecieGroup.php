<?php
namespace src\Presenter\ViewModel;

final class SpecieGroup
{
    /** @param SpecieRow[] $rows */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows
    ) {}
}
