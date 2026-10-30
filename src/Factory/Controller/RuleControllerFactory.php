<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\PublicBase;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Page\PageList;

final class RuleControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createCategoryController(string $slug): ?PublicBase
    {
        $menu = new MenuPresenter(PageRegistry::getInstance()->all(), C::RULES);
echo "[[$slug]]";
        return match($slug) {
            C::GLOSSARY => new PublicGlossary(),
            /*
            C::ARMOR  => new PublicItemArmor(
                $this->readerFactory->armor(),
                new ArmorListPresenter(),
                new PageList(
                    $this->renderer,
                    new ArmorCardContentBuilder()
                ),
                $menu
            ),
            */
            default              => null,
        };
    }

    /*
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
    */
}
