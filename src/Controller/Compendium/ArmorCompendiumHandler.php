<?php
namespace src\Controller\Compendium;

use src\Constant\Field;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Criteria\ArmorCriteria;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Page\PageList;
use src\Repository\ArmorRepository;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;

final class ArmorCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $repository = new ArmorRepository(new QueryBuilder(), new QueryExecutor());

        $armors = $repository->findAllWithItemAndType(
            new ArmorCriteria(),
            [
                Field::ARMORTYPID => Constant::CST_ASC,
                Field::ARMORCLASS => Constant::CST_ASC,
                Field::GOLDPRICE  => Constant::CST_ASC,
            ]
        );

        $presenter = new ArmorListPresenter();
        $content   = $presenter->present($armors);

        $page = new PageList(
            new TemplateRenderer(),
            new ArmorTableBuilder()
        );

        return $page->renderAdmin(Language::LG_ARMORS_TITLE, $content);
    }
}
