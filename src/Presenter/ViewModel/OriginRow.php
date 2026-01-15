<?php
namespace src\Presenter\ViewModel;

final class OriginRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $abilities,
        public string $originFeat,
        public string $skills,
        public string $tool
    ) {}
}
