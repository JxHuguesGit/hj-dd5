<?php
namespace src\Presenter\ViewModel;

class MenuItem
{
    public function __construct(
        public string $id,
        public string $label,
        public string $icon
    ) {}
}
