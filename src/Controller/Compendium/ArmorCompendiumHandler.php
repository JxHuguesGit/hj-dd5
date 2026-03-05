<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Domain\Criteria\ArmorCriteria;
use src\Page\PageList;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Service\Reader\ArmorReader;

final class ArmorCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private ArmorReader $reader,
        private ArmorListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $criteria = new ArmorCriteria();
        $criteria->orderBy = [
            F::ARMORTYPID => Constant::CST_ASC,
            F::ARMORCLASS => Constant::CST_ASC,
            F::GOLDPRICE  => Constant::CST_ASC,
        ];
        $armors = $this->reader->allArmors($criteria);
        $content   = $this->presenter->present($armors);
        return $this->page->renderAdmin('', $content);
    }
}
