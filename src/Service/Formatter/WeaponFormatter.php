<?php
namespace src\Service\Formatter;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Domain\Entity\Weapon;
use src\Service\Domain\WpPostService;
use src\Service\Reader\WeaponPropertyValueReader;
use src\Utils\Html;

final class WeaponFormatter
{
    public function __construct(
        private WpPostService $wpPostService,
        private WeaponPropertiesFormatter $formatter,
        private WeaponPropertyValueReader $weaponPropertyValue
    ) {}

    public function properties(Weapon $weapon): string
    {
        $weaponPropertyValues = $this->weaponPropertyValue->byWeaponId($weapon->id);
        if ($weaponPropertyValues->isEmpty()) {
            return '-';
        }

        $parts = [];
        foreach ($weaponPropertyValues as $weaponPropertyValue) {
            $parts[] = $this->formatter->format($weaponPropertyValue, $this->wpPostService);
        }
        return implode(' ', $parts);
    }

    public function masteryLink(Weapon $weapon): string
    {
        $this->wpPostService->getById($weapon->masteryPostId);
        $linkTag = Html::getLink($weapon->masteryName, '#', B::TEXT_DARK);
        $tooltipContent = Html::getSpan($this->wpPostService->getPostContent() ?? '', [C::CSSCLASS => 'tooltip-text']);

        return Html::getSpan($linkTag . $tooltipContent, [C::CSSCLASS => 'tooltip-trigger']);
    }
}
