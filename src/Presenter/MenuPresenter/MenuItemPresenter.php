<?php
namespace src\Presenter\MenuPresenter;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Presenter\ViewModel\MenuItem;
use src\Utils\UrlGenerator;

class MenuItemPresenter
{
    public function __construct(
        private MenuItem $item,
        private string $currentTab,
        private string $currentId,
    ) {}

    private function isActive(): bool
    {
        return $this->currentId == $this->item->id
        && $this->currentTab == C::ONG_COMPENDIUM;
    }

    private function formatAttributes(
        string $url,
        bool $isActive,
        string $icon,
        string $label,
        string $show,
        string $initiales = ''
    ): array {
        return [
            '',
            $url,
            $isActive ? C::ACTIVE : '',
            $icon,
            $label,
            $show,
            '',
            '',
            $initiales,
        ];
    }

    public function toTemplateAttributes(): array
    {
        return $this->formatAttributes(
            UrlGenerator::admin(C::ONG_COMPENDIUM, $this->item->id),
            $this->isActive(),
            $this->item->icon,
            $this->item->label,
            B::DNONE,
        );
    }

    public function toTemplateAttributesNewCharacter(string $url): array
    {
        return $this->formatAttributes(
            sprintf($url, 0, 'name'),
            $this->isActive() && $this->item->id == 0,
            $this->item->icon,
            $this->item->label,
            B::DNONE,
        );
    }

    public function toTemplateAttributesCharacter(string $url, string $step): array
    {
        $name      = $this->item->label;
        $parts     = explode(' ', $name);
        $initiales = substr($parts[0], 0, 1) . substr($parts[1] ?? '', 0, 1);
        return $this->formatAttributes(
            sprintf($url, $this->item->id, $step),
            $this->isActive(),
            $this->item->icon,
            $name,
            B::DNONE,
            $initiales
        );
    }

    public function toTemplateAttributesCompendium(): array
    {
        return $this->formatAttributes(
            UrlGenerator::admin(C::ONG_COMPENDIUM, $this->item->id),
            $this->isActive(),
            $this->item->icon,
            $this->item->label,
            B::DNONE,
        );
    }
}
