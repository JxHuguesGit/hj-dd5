<?php
namespace src\Presenter\ViewModel;

final class GearRow
{
    public function __construct(
        public string $name,
        // TODO : vérifier utilisation, pour suppression éventuelle
        public string $slug,
        // TODO : vérifier utilisation, pour suppression éventuelle
        public string $description,
        public string $url,
        public string $weight,
        public string $price
    ) {}
}
