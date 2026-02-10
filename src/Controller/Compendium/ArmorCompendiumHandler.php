<?php
namespace src\Controller\Compendium;

use src\Constant\Field;
use src\Constant\Constant;
use src\Domain\Criteria\ArmorCriteria;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Page\PageList;
use src\Repository\ArmorRepository;

final class ArmorCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private ArmorRepository $repository,
        private ArmorListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $armors = $this->repository->findAllWithItemAndType(
            new ArmorCriteria(),
            [
                Field::ARMORTYPID => Constant::CST_ASC,
                Field::ARMORCLASS => Constant::CST_ASC,
                Field::GOLDPRICE  => Constant::CST_ASC,
            ]
        );
        $content   = $this->presenter->present($armors);
        return $this->page->renderAdmin('', $content);
    }
}
