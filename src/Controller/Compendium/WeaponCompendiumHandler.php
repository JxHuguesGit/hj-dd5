<?php
namespace src\Controller\Compendium;

use src\Constant\Field;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Criteria\WeaponCriteria;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\WeaponTableBuilder;
use src\Page\PageList;
use src\Repository\WeaponRepository;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\WeaponPropertyValueRepository;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\WeaponPropertyValueReader;

final class WeaponCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $repository = new WeaponRepository(new QueryBuilder(), new QueryExecutor());

        $weapons = $repository->findAllWithItemAndType(
            new WeaponCriteria(),
            [
                Field::WPNCATID   => Constant::CST_ASC,
                Field::WPNRANGEID => Constant::CST_ASC,
                'i.name'          => Constant::CST_ASC,
            ]
        );

        $presenter = new WeaponListPresenter(
            new WpPostService(),
            new WeaponPropertiesFormatter(),
            new WeaponPropertyValueReader(
                new WeaponPropertyValueRepository(
                    new QueryBuilder(),
                    new QueryExecutor()
                )
            )
        );

        $content = $presenter->present($weapons);

        $page = new PageList(
            new TemplateRenderer(),
            new WeaponTableBuilder()
        );

        return $page->renderAdmin('', $content);
    }
}
