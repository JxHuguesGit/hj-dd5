<?php
namespace src\Factory;

use src\Constant\Constant;
use src\Controller\Public\{
    PublicOrigines,
    PublicSpecies,
    PublicSkills,
    PublicFeats,
    PublicSpells,
    PublicBase,
    PublicItems
};
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Presenter\ListPresenter\{
    FeatListPresenter,
    OriginListPresenter,
    SkillListPresenter,
    SpeciesListPresenter,
    SpellListPresenter
};
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\{
    FeatTableBuilder,
    OriginTableBuilder,
    SkillTableBuilder,
    SpeciesTableBuilder,
    SpellTableBuilder
};
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Page\PageList;
use src\Service\Domain\SpellService;
use src\Controller\Utilities;

final class PublicControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory
    ) {}

    public function create(string $slug): ?PublicBase
    {
        return match ($slug) {

            Constant::ORIGINES => new PublicOrigines(
                $this->readerFactory->origin(),
                new OriginListPresenter(
                    $this->serviceFactory->origin()
                ),
                new PageList(
                    new TemplateRenderer(),
                    new OriginTableBuilder(
                        $this->serviceFactory->origin(),
                        $this->readerFactory->origin()
                    )
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), Constant::ORIGINES)
            ),

            Constant::SPECIES => new PublicSpecies(
                $this->readerFactory->species(),
                new SpeciesListPresenter(
                    $this->serviceFactory->wordPress()
                ),
                new PageList(
                    new TemplateRenderer(),
                    new SpeciesTableBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES)
            ),

            Constant::SKILLS => new PublicSkills(
                $this->readerFactory->skill(),
                new SkillListPresenter(
                    $this->serviceFactory->skill()
                ),
                new PageList(
                    new TemplateRenderer(),
                    new SkillTableBuilder(
                        $this->serviceFactory->skill()
                    )
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS)
            ),

            Constant::FEATS => new PublicFeats(
                $this->readerFactory->feat(),
                new FeatListPresenter(
                    $this->readerFactory->origin(),
                    $this->serviceFactory->wordPress()
                ),
                new PageList(
                    new TemplateRenderer(),
                    new FeatTableBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
            ),

            Constant::SPELLS => new PublicSpells(
                new SpellService(
                    $this->serviceFactory->wordPress()
                ),
                new SpellListPresenter(
                    $this->readerFactory->spell(),
                    $this->serviceFactory->wordPress()
                ),
                new PageList(
                    new TemplateRenderer(),
                    new SpellTableBuilder(
                        $this->readerFactory->spell()
                    )
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPELLS),
                new SpellFilterModalPresenter(
                    new Utilities()
                )
            ),

            Constant::CST_ITEMS => new PublicItems(),

            default => null,
        };
    }
}
