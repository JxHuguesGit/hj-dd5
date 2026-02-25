<?php
namespace src\Domain\CharacterCreation;

use src\Domain\Character\Character;
use src\Service\Domain\CharacterServices;

interface StepInterface
{
    public function getId(): string;
    public function getTitle(): string;

    public function render(Character $character): array;
    public function validate(array $input): bool;
    public function save(CharacterServices $services, Character $character, array $input): void;

    public function isComplete(Character $character): bool;
}
