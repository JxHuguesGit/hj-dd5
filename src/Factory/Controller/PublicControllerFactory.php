<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicFeats;
use src\Controller\Public\PublicItems;
use src\Controller\Public\PublicOrigines;
use src\Controller\Public\PublicSkills;
use src\Controller\Public\PublicSpecies;
use src\Controller\Public\PublicSpells;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ContentBuilder\FeatCardContentBuilder;
use src\Presenter\ContentBuilder\ItemCategoryContentBuilder;
use src\Presenter\ContentBuilder\OriginCardContentBuilder;
use src\Presenter\ContentBuilder\SkillCardContentBuilder;
use src\Presenter\ContentBuilder\SpecieCardContentBuilder;
use src\Presenter\ContentBuilder\SpellCardContentBuilder;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\ListPresenter\SpeciesListPresenter;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Renderer\TemplateRenderer;

final class PublicControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function create(string $slug): ?PublicBase
    {
        return match ($slug) {

            C::ORIGINES  => new PublicOrigines(
                $this->readerFactory->origin(),
                new OriginListPresenter(
                    $this->readerFactory->reference(),
                    $this->serviceFactory->origin()
                ),
                new PageList(
                    $this->renderer,
                    new OriginCardContentBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), C::ORIGINES)
            ),

            C::SPECIES   => new PublicSpecies(
                $this->readerFactory->species(),
                new SpeciesListPresenter(
                    $this->readerFactory->reference(),
                    $this->serviceFactory->wordPress()
                ),
                new PageList(
                    $this->renderer,
                    new SpecieCardContentBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), C::SPECIES)
            ),

            C::SKILLS    => new PublicSkills(
                $this->readerFactory->skill(),
                new SkillListPresenter(
                    $this->readerFactory->skill()
                ),
                new PageList(
                    $this->renderer,
                    new SkillCardContentBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), C::SKILLS)
            ),

            C::FEATS     => new PublicFeats(
                $this->readerFactory->feat(),
                new FeatListPresenter(
                    $this->readerFactory->origin(),
                    $this->serviceFactory->featPreRequis(),
                    $this->readerFactory->featType(),
                    $this->readerFactory->reference(),
                    $this->readerFactory->featAbility(),
                    $this->readerFactory->ability()
                ),
                new PageList(
                    $this->renderer,
                    new FeatCardContentBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), C::FEATS)
            ),

            C::SPELLS    => new PublicSpells(
                $this->serviceFactory->spell(),
                new SpellListPresenter(),
                new SpellCardContentBuilder(),
                $this->renderer,
                new MenuPresenter(PageRegistry::getInstance()->all(), C::SPELLS),
                new SpellFilterModalPresenter(
                    $this->readerFactory->reference(),
                    $this->readerFactory->spellSchool(),
                    $this->readerFactory->classe(),
                    $this->renderer
                )
            ),

            C::ITEMS => new PublicItems(
                new PageList(
                    $this->renderer,
                    new ItemCategoryContentBuilder()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), C::ITEMS),
            ),

            default             => null,
        };
    }
}
