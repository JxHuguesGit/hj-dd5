<?php
namespace src\Presenter\ViewModel;

final class OriginGroup
{
    /**
     * @param OriginRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows,
        public string $extra = ''
    ) {}
}
