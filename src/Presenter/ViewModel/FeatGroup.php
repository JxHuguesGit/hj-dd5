<?php
namespace src\Presenter\ViewModel;

class FeatGroup
{
    public function __construct(
        public string $label,
        public string $slug,
        public string $extraprerequis,
        /** @var DomainFeat[] */
        public array $feats
    ) {}
}
