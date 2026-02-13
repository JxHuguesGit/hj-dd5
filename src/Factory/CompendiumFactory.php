<?php
namespace src\Factory;

use src\Controller\Compendium\{ArmorCompendiumHandler, FeatCompendiumHandler, GearCompendiumHandler, MonsterCompendiumHandler, OriginCompendiumHandler, SkillCompendiumHandler, SpellCompendiumHandler, ToolCompendiumHandler, WeaponCompendiumHandler};
use src\Page\PageList;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Presenter\TableBuilder\WeaponTableBuilder;
use src\Presenter\ToastBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\{ArmorRepository, FeatRepository, FeatTypeRepository, ItemRepository, MonsterRepository, OriginRepository, ReferenceRepository, MonsterSubTypeRepository, MonsterTypeRepository, WeaponPropertyValueRepository, WeaponRepository};
use src\Service\Domain\WpPostService;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\{FeatReader, FeatTypeReader, ItemReader, MonsterReader, OriginReader, ReferenceReader, MonsterSubTypeReader, MonsterTypeReader, WeaponPropertyValueReader, WeaponReader};

final class CompendiumFactory
{
    public function __construct(
        private QueryBuilder $qb,
        private QueryExecutor $qe,
        private TemplateRenderer $renderer
    ) {}

    public function armor(): ArmorCompendiumHandler
    {
        return new ArmorCompendiumHandler(
            new ArmorRepository($this->qb, $this->qe),
            new ArmorListPresenter(),
            new PageList($this->renderer, new ArmorTableBuilder())
        );
    }

    public function monster(): MonsterCompendiumHandler
    {
        return new MonsterCompendiumHandler(
            new MonsterReader(new MonsterRepository($this->qb, $this->qe)),
            new MonsterListPresenter(
                new MonsterFormatter(
                    new MonsterTypeReader(new MonsterTypeRepository($this->qb, $this->qe)),
                    new MonsterSubTypeReader(new MonsterSubTypeRepository($this->qb, $this->qe)),
                ),
                new ReferenceReader(new ReferenceRepository($this->qb, $this->qe))
            ),
            new PageList($this->renderer, new MonsterTableBuilder()),
            $this->renderer
        );
    }

    public function weapon(): WeaponCompendiumHandler
    {
        return new WeaponCompendiumHandler(
            new WeaponReader(new WeaponRepository($this->qb, $this->qe)),
            new WeaponListPresenter(
                new WpPostService(),
                new WeaponPropertiesFormatter(),
                new WeaponPropertyValueReader(
                    new WeaponPropertyValueRepository($this->qb, $this->qe)
                )
            ),
            new PageList(
                new TemplateRenderer(),
                new WeaponTableBuilder()
            )
        );
    }

    public function skill(): SkillCompendiumHandler
    {
        return new SkillCompendiumHandler();
    }

    public function gear(): GearCompendiumHandler
    {
        $itemRepository = new ItemRepository($this->qb, $this->qe);
        return new GearCompendiumHandler(
            $itemRepository,
            new ItemReader($itemRepository),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }

    public function feat(): FeatCompendiumHandler
    {
        $featRepository = new FeatRepository($this->qb, $this->qe);
        $featTypeRepository = new FeatTypeRepository($this->qb, $this->qe);
        return new FeatCompendiumHandler(
            $featRepository,
            new FeatReader($featRepository),
            new FeatTypeReader($featTypeRepository),
            new OriginReader(new OriginRepository($this->qb, $this->qe)),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }

    public function origin(): OriginCompendiumHandler
    {
        return new OriginCompendiumHandler();
    }

    public function tool(): ToolCompendiumHandler
    {
        return new ToolCompendiumHandler();
    }

    public function spell(): SpellCompendiumHandler
    {
        return new SpellCompendiumHandler();
    }
}
