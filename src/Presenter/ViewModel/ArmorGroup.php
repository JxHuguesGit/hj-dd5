<?php
namespace src\Presenter\ViewModel;

use src\Presenter\ViewModel\ArmorRow;

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
