<?php
namespace src\Domain\CharacterCreation\Step;

abstract class AbstractBaseStep
{
    public ?string $id       = '';
    public ?string $title    = '';
    public ?string $template = '';

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

}
