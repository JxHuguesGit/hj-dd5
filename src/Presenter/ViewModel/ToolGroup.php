<?php
namespace src\Presenter\ViewModel;

class ToolGroup
{
    public function __construct(
        public string $label,
        public string $slug,
        /** @var DomainTool[] */
        public array $tools
    ) {}
}
