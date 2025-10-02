<?php
namespace src\Entity;

class Translation extends Entity
{
    public function __construct(
        protected string $clef,
        protected string $lang,
        protected mixed $value
    ) {

    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
