<?php
namespace src\Presenter\ViewModel;

final class FeatGroup
{
    /**
     * @param FeatRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows,
        public string $extraPrerequis = ''
    ) {}
}
