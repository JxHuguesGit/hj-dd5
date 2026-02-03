<?php
namespace src\Presenter\ViewModel;

final class ToolRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $originLabel,
        public string $weight,
        public string $price
    ) {}
}
