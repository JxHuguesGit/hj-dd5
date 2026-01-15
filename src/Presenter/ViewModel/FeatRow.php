<?php
namespace src\Presenter\ViewModel;

final class FeatRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $originLabel,
        public string $prerequisite
    ) {}
}
