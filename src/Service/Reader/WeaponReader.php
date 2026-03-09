<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Domain\Criteria\WeaponCriteria;
use src\Domain\Entity\Weapon;
use src\Repository\WeaponRepositoryInterface;
use src\Utils\Navigation;

final class WeaponReader
{
    public function __construct(
        private WeaponRepositoryInterface $weaponRepository
    ) {}

    /**
     * @return ?Weapon
     */
    public function itemBySlug(string $slug): ?Weapon
    {
        $criteria = new WeaponCriteria();
        $criteria->slug = $slug;
        return $this->weaponRepository->findAllWithRelations($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Weapon>
     */
    public function allWeapons(): Collection
    {
        return $this->weaponRepository->findAllWithRelations(new WeaponCriteria());
    }

    public function getPreviousAndNext(Weapon $weapon): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($weapon) {
                $criteria = new WeaponCriteria();
                $criteria->weaponCategoryId = $weapon->weaponCategoryId;
                $criteria->weaponRangeId = $weapon->weaponRangeId;
                $operand === '&lt;'
                    ? $criteria->nameLt = $weapon->name
                    : $criteria->nameGt = $weapon->name
                ;
                $criteria->orderBy = ['i.'.F::NAME => $order];
                return $this->weaponRepository->findAllWithRelations($criteria);
            }
        );
    }
}
