<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Field;
use src\Domain\Criteria\ArmorCriteria;
use src\Domain\Entity\Armor;
use src\Repository\ArmorRepositoryInterface;
use src\Utils\Navigation;

final class ArmorReader
{
    public function __construct(
        private ArmorRepositoryInterface $armorRepository
    ) {}

    /**
     * @return ?Armor
     */
    public function itemBySlug(string $slug): ?Armor
    {
        $criteria = new ArmorCriteria();
        $criteria->slug = $slug;
        return $this->armorRepository->findAllWithItemAndType($criteria)?->first() ?? null;
    }
     
    /**
     * @return Collection<DomainArmor>
     */
    public function allArmors(): Collection
    {
        return $this->armorRepository->findAllWithItemAndType(new ArmorCriteria());
    }

    public function getPreviousAndNext(Armor $armor): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($armor) {
                $criteria = new ArmorCriteria();
                $operand === '&lt;'
                    ? $criteria->nameLt = $armor->name
                    : $criteria->nameGt = $armor->name
                ;
                $criteria->orderBy = [Field::NAME => $order];
                return $this->armorRepository->findAllWithItemAndType($criteria);
            }
        );
    }
}
