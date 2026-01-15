<?php
namespace src\Presenter\ViewModel;

class ArmorGroup
{
    public function __construct(
        public string $label,
        public string $slug,
        /** @var DomainArmor[] */
        public array $armors
    ) {}
}
