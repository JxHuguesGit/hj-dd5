<?php
namespace src\Presenter\ViewModel;

final class SkillLink
{
    public function __construct(
        public string $name,
        public string $url
    ) {}
}