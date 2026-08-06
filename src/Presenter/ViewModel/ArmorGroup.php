<?php
namespace src\Presenter\ViewModel;

final class ArmorGroup
{
    /**
     * @param ArmorRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows
    ) {}
}
