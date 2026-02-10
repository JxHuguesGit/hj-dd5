<?php
namespace src\Service\Domain;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\Entity\Ability;
use src\Domain\Entity\Origin;
use src\Repository\WeaponPropertyValueRepository;
use src\Service\Reader\WeaponPropertyValueReader;

final class WeaponService
{
    /** @var array<int, Ability> */
    private array $wpnPropValueCache = [];
    
    public function __construct(
        private WeaponPropertyValueRepository $weaponPropertyValueRepository,
        private WeaponPropertyValueReader $weaponPropertyValueReader,
    ) {}
    
    public function getProperties(Origin $weapon): Collection
    {
        $weaponPropertyValues = $this->weaponPropertyValueRepository->findBy([
            Field::WEAPONID => $weapon->id
        ]);

        $collection = new Collection();
        foreach ($weaponPropertyValues as $weaponPropertyValue) {
            $wpValueId = $weaponPropertyValue->itemId;
            $wpValue = $this->weaponPropertyValueReader->weaponPropertyValueById($wpValueId);
            if ($wpValue!==null) {
                $this->wpnPropValueCache[$wpValueId] ??= $wpValue;
                $collection->add($this->wpnPropValueCache[$wpValueId]);
            }
        }
        return $collection;
    }
}
