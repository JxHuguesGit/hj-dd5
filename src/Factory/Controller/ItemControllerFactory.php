<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\{
    PublicBase,
    PublicItemArmor,
    PublicItemArmorDetail,
    PublicItemGear,
    PublicItemGearDetail,
    PublicItemTool,
    PublicItemToolDetail,
    PublicItemWeapon,
    PublicItemWeaponDetail,
};
use src\Domain\Criteria\ItemCriteria;
use src\Domain\Entity\Item;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\Renderer\{PageItemArmor, PageItemGear, PageItemTool, PageItemWeapon};
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Page\PageList;
use src\Presenter\ContentBuilder\ArmorCardContentBuilder;
use src\Presenter\ContentBuilder\ArmorDetailContentBuilder;
use src\Presenter\ContentBuilder\GearCardContentBuilder;
use src\Presenter\ContentBuilder\GearDetailContentBuilder;
use src\Presenter\ContentBuilder\ToolCardContentBuilder;
use src\Presenter\ContentBuilder\ToolDetailContentBuilder;
use src\Presenter\ContentBuilder\WeaponCardContentBuilder;
use src\Presenter\ContentBuilder\WeaponDetailContentBuilder;
use src\Presenter\ListPresenter\{ArmorListPresenter, GearListPresenter, ToolListPresenter, WeaponListPresenter};
use src\Presenter\ViewModel\{ArmorPageView, GearPageView, ToolPageView, WeaponPageView};

final class ItemControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createCategoryController(string $slug): ?PublicBase
    {
        $menu = new MenuPresenter(PageRegistry::getInstance()->all(), C::ITEMS);

        return match($slug) {
            C::ARMOR  => new PublicItemArmor(
                $this->readerFactory->armor(),
                new ArmorListPresenter(),
                new PageList(
                    $this->renderer,
                    new ArmorCardContentBuilder()
                ),
                $menu
            ),
            C::TOOL   => new PublicItemTool(
                $this->readerFactory->tool(),
                new ToolListPresenter($this->readerFactory->origin()),
                new PageList(
                    $this->renderer,
                    new ToolCardContentBuilder()
                ),
                $menu
            ),
            C::WEAPON => new PublicItemWeapon(
                $this->readerFactory->weapon(),
                new WeaponListPresenter(
                    $this->serviceFactory->weaponFormatter()
                ),
                new PageList(
                    $this->renderer,
                    new WeaponCardContentBuilder()
                ),
                $menu
            ),
            C::GEAR   => new PublicItemGear(
                $this->readerFactory->item(),
                new GearListPresenter(),
                new PageList(
                    $this->renderer,
                    new GearCardContentBuilder()
                ),
                $menu
            ),
            default              => null,
        };
    }

    public function createDetailController(string $slug): ?PublicBase
    {
        $menu = new MenuPresenter(PageRegistry::getInstance()->all(), C::ITEMS);

        $criteria = new ItemCriteria();
        $criteria->type = null;
        $item = $this->readerFactory->item()->itemBySlug($slug, $criteria);

        return match($item?->type) {
            C::ARMOR  => $this->createArmorDetail($slug, $menu),
            C::TOOL => $this->createToolDetail($slug, $menu),
            C::WEAPON => $this->createWeaponDetail($slug, $menu),
            C::OTHER => $this->createOtherDetail($item, $menu),
            default              => null
        };
    }

    private function createOtherDetail(Item $item, MenuPresenter $menu): ?PublicBase
    {
        $nav = $this->readerFactory->item()->getPreviousAndNext($item);

        return new PublicItemGearDetail(
            $menu,
            new GearPageView(
                $item,
                $nav[C::PREV],
                $nav[C::NEXT],
            ),
            new PageItemGear(
                $this->renderer,
                new GearDetailContentBuilder()
            )
        );
    }

    private function createToolDetail(string $slug, MenuPresenter $menu): ?PublicBase
    {
        $item = $this->readerFactory->tool()->itemBySlug($slug);
        if (!$item) {
            return null;
        }

        $origins = $this->readerFactory->origin()->originsByTool($item);
        $craftableItems = $this->readerFactory->item()->craftableItemsByTool($item);
        $nav = $this->readerFactory->tool()->getPreviousAndNext($item);

        return new PublicItemToolDetail(
            $menu,
            new ToolPageView(
                $item,
                $origins,
                $craftableItems,
                $nav[C::PREV],
                $nav[C::NEXT],
            ),
            new PageItemTool(
                $this->renderer,
                new ToolDetailContentBuilder()
            )
        );
    }

    private function createArmorDetail(string $slug, MenuPresenter $menu): ?PublicBase
    {
        $item = $this->readerFactory->armor()->itemBySlug($slug);
        if (!$item) {
            return null;
        }

        $nav = $this->readerFactory->armor()->getPreviousAndNext($item);
        return new PublicItemArmorDetail(
            $menu,
            new ArmorPageView(
                $item,
                $nav[C::PREV],
                $nav[C::NEXT],
            ),
            new PageItemArmor(
                $this->renderer,
                new ArmorDetailContentBuilder()
            )
        );
    }

    private function createWeaponDetail(string $slug, MenuPresenter $menu): ?PublicBase
    {
        $item = $this->readerFactory->weapon()->itemBySlug($slug);
        if (!$item) {
            return null;
        }

        $nav = $this->readerFactory->weapon()->getPreviousAndNext($item);
        return new PublicItemWeaponDetail(
            $menu,
            new WeaponPageView(
                $item,
                $nav[C::PREV],
                $nav[C::NEXT],
            ),
            new PageItemWeapon(
                $this->renderer,
                new WeaponDetailContentBuilder(
                    $this->serviceFactory->weaponFormatter()
                )
            )
        );
    }
}
