<?php
namespace src\Presenter\ViewModel;

final class SpellPageView
{
    public function __construct(
        public readonly SpellDetail $spell,
        public readonly ?SpellDetail $previous = null,
        public readonly ?SpellDetail $next = null
    ) {}

    public function hasPrevious(): bool
    {
        return $this->previous !== null;
    }

    public function hasNext(): bool
    {
        return $this->next !== null;
    }
}
