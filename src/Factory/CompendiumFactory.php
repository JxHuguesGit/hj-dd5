<?php
namespace src\Factory;

use src\Controller\Compendium\ArmorCompendiumHandler;
use src\Controller\Compendium\FeatCompendiumHandler;
use src\Controller\Compendium\GearCompendiumHandler;
use src\Controller\Compendium\MonsterCompendiumHandler;
use src\Controller\Compendium\OriginCompendiumHandler;
use src\Controller\Compendium\SkillCompendiumHandler;
use src\Controller\Compendium\SpellCompendiumHandler;
use src\Controller\Compendium\ToolCompendiumHandler;
use src\Controller\Compendium\WeaponCompendiumHandler;
use src\Page\PageList;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Presenter\TableBuilder\WeaponTableBuilder;
use src\Presenter\ToastBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\ArmorRepository;
use src\Repository\FeatRepository;
use src\Repository\FeatTypeRepository;
use src\Repository\ItemRepository;
use src\Repository\OriginRepository;
use src\Repository\WeaponPropertyValueRepository;
use src\Repository\WeaponRepository;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\WeaponPropertyValueReader;
use src\Service\Reader\WeaponReader;

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
        return new MonsterCompendiumHandler();
    }

    public function weapon(): WeaponCompendiumHandler
    {
        $weaponRepository = new WeaponRepository($this->qb, $this->qe);
        return new WeaponCompendiumHandler(
            new WeaponReader($weaponRepository),
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
