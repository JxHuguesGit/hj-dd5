<?php
namespace src\Presenter\ViewModel;

final class FeatRow
{
    /**
     * @param LinkView[] $origins
     * @param LinkView[] $abilities
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public string $url,
        public string $sourceName,
        public array $origins = [],
        public array $abilities = [],
        public ?string $prerequisite = null,
    ) {}
}
