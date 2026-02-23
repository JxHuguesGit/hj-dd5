<?php
namespace src\Domain\CharacterCreation;

interface StepInterface
{
    public function getId(): string;
    public function getTitle(): string;

    public function render(CharacterDraft $draft): array;
    public function validate(array $input): bool;
    public function save(CharacterDraft $draft, array $input): void;

    public function isComplete(CharacterDraft $draft): bool;
}
