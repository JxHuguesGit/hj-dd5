<?php
namespace src\Service\Domain;

use src\Service\Reader\CharacterReader;
use src\Service\Writer\CharacterWriter;

final class CharacterServices
{
    public function __construct(
        private CharacterReader $reader,
        private CharacterWriter $writer,
    ) {}

    public function reader(): CharacterReader
    {
        return $this->reader;
    }

    public function writer(): CharacterWriter
    {
        return $this->writer;
    }
}
