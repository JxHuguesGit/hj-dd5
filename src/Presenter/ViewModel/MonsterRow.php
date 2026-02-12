<?php
namespace src\Presenter\ViewModel;

final class MonsterRow
{
    public function __construct(
        public string $name,
        public string $cr,
        public string $type,
        public string $ca,
        public string $hp,
        public string $reference
    ) {}
}
