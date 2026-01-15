<?php
namespace src\Presenter\ViewModel;

use src\Domain\Armor as DomainArmor;

final class ArmorGroup
{
    /**
     * @param ArmorRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows,
        public string $extra = ''
    ) {}
}
