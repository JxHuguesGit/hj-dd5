<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\ViewModel\PageViewInterface;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\WeaponPropertyValueRepository;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponFormatter;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\WeaponPropertyValueReader;
use src\Utils\Utils;

class WeaponDetailPresenter extends AbstractItemDetailPresenter
{
    public function present(PageViewInterface $viewData): array
    {
        $formatter = new WeaponFormatter(
            new WpPostService(),
            new WeaponPropertiesFormatter(),
            new WeaponPropertyValueReader(
                new WeaponPropertyValueRepository(
                    new QueryBuilder(),
                    new QueryExecutor()
                ),
            )
        );

        /** @var PageViewInterface $viewData */
        $base = parent::present($viewData);

        $key = ($viewData->weapon->isMartial() ? Constant::CST_MARTIAL : Constant::CST_SIMPLE) . '_'
                . ($viewData->weapon->isMelee() ? Constant::CST_MELEE : Constant::CST_RANGED);
        $base['category'] = (WeaponListPresenter::getWeaponTypes())[$key][Constant::CST_LABEL_SING];
        $base['damage'] = Utils::getStrDamage($viewData->weapon);
        $base['properties'] = $formatter->properties($viewData->weapon);
        $base['masteryLink'] = $formatter->masteryLink($viewData->weapon);

        return $base;
    }
}
