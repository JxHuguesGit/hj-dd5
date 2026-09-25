<?php
namespace src\Factory;

use src\Controller\Compendium\{
    ArmorCompendiumHandler,
    FeatCompendiumHandler,
    GearCompendiumHandler,
    MonsterCompendiumHandler,
    OriginCompendiumHandler,
    SkillCompendiumHandler,
    SpellCompendiumHandler,
    ToolCompendiumHandler,
    WeaponCompendiumHandler
};
use src\Factory\Compendium\{
    ArmorCompendiumFactory,
    FeatCompendiumFactory,
    GearCompendiumFactory,
    MonsterCompendiumFactory,
    OriginCompendiumFactory,
    SkillCompendiumFactory,
    SpellCompendiumFactory,
    ToolCompendiumFactory,
    WeaponCompendiumFactory
};
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;

final class CompendiumFactory
{
    public function __construct(
        private TemplateRenderer $renderer,
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function armor(): ArmorCompendiumHandler
    {
        return (new ArmorCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function feat(): FeatCompendiumHandler
    {
        return (new FeatCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function gear(): GearCompendiumHandler
    {
        return (new GearCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function monster(): MonsterCompendiumHandler
    {
        return (new MonsterCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function origin(): OriginCompendiumHandler
    {
        return (new OriginCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function skill(): SkillCompendiumHandler
    {
        return (new SkillCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function spell(): SpellCompendiumHandler
    {
        return (new SpellCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function tool(): ToolCompendiumHandler
    {
        return (new ToolCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }

    public function weapon(): WeaponCompendiumHandler
    {
        return (new WeaponCompendiumFactory(
            $this->renderer,
            $this->readerFactory,
            $this->writerFactory,
            $this->serviceFactory
        ))->create();
    }
}
