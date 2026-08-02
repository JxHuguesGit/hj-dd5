<?php
namespace src\Presenter\ViewModel;

final class ItemCategory
{
    public function __construct(
        public string $title,
        public string $url,
    ) {}
}
