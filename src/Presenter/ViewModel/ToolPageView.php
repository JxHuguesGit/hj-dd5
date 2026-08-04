<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Entity\Tool;

class ToolPageView implements PageViewInterface
{
    public function __construct(
        public Tool $item,
        public Collection $origins,
        public Collection $craftableItems,
        public ?Tool $previous = null,
        public ?Tool $next = null
    ) {}

    public function getSlug(): string
    {
        return $this->item->slug;
    }

    public function getName(): string
    {
        return $this->item->name;
    }
}
