<?php
namespace src\Domain\CharacterCreation;

use src\Repository\CharacterDraftRepository;

interface StepInterface
{
    public function getId(): string;
    public function getTitle(): string;

    public function render(CharacterDraft $draft): string;
    public function validate(array $input): bool;
    public function save(CharacterDraft $draft, array $input, CharacterDraftRepository $repo): void;

    public function isComplete(CharacterDraft $draft): bool;
}
