<?php
namespace src\Presenter\ViewModel;

final class FeatRow
{
    /**
     * @param LinkView[] $origins
     */
    public function __construct(
        public string $name,
        public string $slug,
        public string $url,
        public string $sourceName,
        public array $origins = [],
        public ?string $prerequisite = null,
    ) {}
}
