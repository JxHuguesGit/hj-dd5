<?php
namespace src\Service;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\Ability as DomainAbility;
use src\Domain\Origin as DomainOrigin;
use src\Repository\WeaponPropertyValue as RepositoryWeaponPropertyValue;
use src\Service\Reader\WeaponPropertyValueReader;

final class WeaponService
{
    /** @var array<int, DomainAbility> */
    private array $wpnPropValueCache = [];
    
    public function __construct(
        private RepositoryWeaponPropertyValue $weaponPropertyValueRepository,
        private WeaponPropertyValueReader $weaponPropertyValueReader,
    ) {}
    
    public function getProperties(DomainOrigin $weapon): Collection
    {
        $weaponPropertyValues = $this->weaponPropertyValueRepository->findBy([
            Field::WEAPONID => $weapon->id
        ]);

        $collection = new Collection();
        foreach ($weaponPropertyValues as $weaponPropertyValue) {
            $wpValueId = $weaponPropertyValue->itemId;
            $wpValue = $this->weaponPropertyValueReader->getWeaponPropertyValue($wpValueId);
            if ($wpValue!==null) {
                $this->wpnPropValueCache[$wpValueId] ??= $wpValue;
                $collection->addItem($this->wpnPropValueCache[$wpValueId]);
            }
        }
        return $collection;
    }
}
