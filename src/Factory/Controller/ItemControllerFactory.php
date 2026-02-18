<?php
namespace src\Factory\Controller;

use src\Constant\Constant;
use src\Controller\Public\{
    PublicBase,
    PublicItemArmor,
    PublicItemArmorDetail,
    PublicItemGear,
    PublicItemTool,
    PublicItemWeapon,
    PublicItemWeaponDetail,
};
use src\Domain\Criteria\ItemCriteria;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\{PageItemArmor, PageItemWeapon};
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Page\PageList;
use src\Presenter\Detail\{ArmorDetailPresenter, WeaponDetailPresenter};
use src\Presenter\ListPresenter\{ArmorListPresenter, GearListPresenter, ToolListPresenter, WeaponListPresenter};
use src\Presenter\TableBuilder\{ArmorTableBuilder, ItemTableBuilder, ToolTableBuilder, WeaponTableBuilder};
use src\Presenter\ViewModel\{ArmorPageView, WeaponPageView};
use src\Query\{QueryBuilder, QueryExecutor};
use src\Repository\WeaponPropertyValueRepository;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\{WeaponFormatter, WeaponPropertiesFormatter};
use src\Service\Reader\WeaponPropertyValueReader;

final class ItemControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createCategoryController(string $slug): ?PublicBase
    {
        $menu = new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS);

        return match($slug) {
            Constant::CST_ARMOR  => new PublicItemArmor(
                $this->readerFactory->armor(),
                new ArmorListPresenter(),
                new PageList($this->renderer, new ArmorTableBuilder()),
                $menu
            ),
            Constant::CST_TOOL   => new PublicItemTool(
                $this->readerFactory->tool(),
                new ToolListPresenter($this->readerFactory->origin()),
                new PageList($this->renderer, new ToolTableBuilder()),
                $menu
            ),
            Constant::CST_WEAPON => new PublicItemWeapon(
                $this->readerFactory->weapon(),
                new WeaponListPresenter(
                    $this->serviceFactory->wordPress(),
                    $this->serviceFactory->weaponProperties(),
                    $this->readerFactory->weaponPropertyValue()
                ),
                new PageList($this->renderer, new WeaponTableBuilder()),
                $menu
            ),
            Constant::CST_GEAR   => new PublicItemGear(
                $this->readerFactory->item(),
                new GearListPresenter(),
                new PageList($this->renderer, new ItemTableBuilder()),
                $menu
            ),
            default              => null,
        };
    }

    public function createDetailController(string $slug): ?PublicBase
    {
        $menu = new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS);

        $criteria = new ItemCriteria();
        $criteria->type = null;
        $item = $this->readerFactory->item()->itemBySlug($slug, $criteria);

        return match($item?->type) {
            Constant::CST_ARMOR  => $this->createArmorDetail($slug, $menu),
            Constant::CST_WEAPON => $this->createWeaponDetail($slug, $menu),
            default              => null
        };
    }

    private function createArmorDetail(string $slug, MenuPresenter $menu): ?PublicBase
    {
        $item = $this->readerFactory->armor()->itemBySlug($slug);
        if (!$item) {
            return null;
        }

        $nav = $this->readerFactory->armor()->getPreviousAndNext($item);
        return new PublicItemArmorDetail(
            new ArmorDetailPresenter(),
            $menu,
            new ArmorPageView(
                $item,
                $nav[Constant::CST_PREV],
                $nav[Constant::CST_NEXT],
            ),
            new PageItemArmor($this->renderer)
        );
    }

    private function createWeaponDetail(string $slug, MenuPresenter $menu): ?PublicBase
    {
        $item = $this->readerFactory->weapon()->itemBySlug($slug);
        if (!$item) {
            return null;
        }

        $nav = $this->readerFactory->weapon()->getPreviousAndNext($item);
        $presenter = new WeaponDetailPresenter(
            new WeaponFormatter(
                new WpPostService(),
                new WeaponPropertiesFormatter(),
                new WeaponPropertyValueReader(
                    new WeaponPropertyValueRepository(
                        new QueryBuilder(),
                        new QueryExecutor()
                    ),
                )
            )
        );
        return new PublicItemWeaponDetail(
            $presenter,
            $menu,
            new WeaponPageView(
                $item,
                $nav[Constant::CST_PREV],
                $nav[Constant::CST_NEXT],
            ),
            new PageItemWeapon($this->renderer)
        );
    }
}
