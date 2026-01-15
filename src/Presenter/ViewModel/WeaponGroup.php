<?php
namespace src\Presenter\ViewModel;

final class WeaponGroup
{
    /**
     * @param WeaponRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows,
        public string $extra = ''
    ) {}
}
