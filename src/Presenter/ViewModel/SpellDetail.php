<?php
namespace src\Presenter\ViewModel;

final class SpellDetail
{
    public function __construct(
        public string $name,
        public string $url,
        public int $niveau,
        public string $ecole,
        public array $classes,
        public bool $rituel,
        public string $tpsInc,
        public string $portee,
        public string $duree,
        public bool $concentration,
        public array $composantes,
        public ?string $composanteMaterielle,
        public string $description,
        public string $source
    ) {}
}
