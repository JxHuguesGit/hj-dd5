<?php
namespace src\Presenter\ViewModel;

final class GearRow
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,
        public string $url,
        public string $weight,
        public string $price
    ) {}
}
