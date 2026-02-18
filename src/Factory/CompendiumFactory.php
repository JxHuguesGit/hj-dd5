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
use src\Query\{QueryBuilder, QueryExecutor};
use src\Renderer\TemplateRenderer;

final class CompendiumFactory
{
    public function __construct(
        private QueryBuilder $qb,
        private QueryExecutor $qe,
        private TemplateRenderer $renderer
    ) {}

    public function armor(): ArmorCompendiumHandler
    {
        return (new ArmorCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function feat(): FeatCompendiumHandler
    {
        return (new FeatCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function gear(): GearCompendiumHandler
    {
        return (new GearCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function monster(): MonsterCompendiumHandler
    {
        return (new MonsterCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function origin(): OriginCompendiumHandler
    {
        return (new OriginCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function skill(): SkillCompendiumHandler
    {
        return (new SkillCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function spell(): SpellCompendiumHandler
    {
        return (new SpellCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function tool(): ToolCompendiumHandler
    {
        return (new ToolCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }

    public function weapon(): WeaponCompendiumHandler
    {
        return (new WeaponCompendiumFactory($this->qb, $this->qe, $this->renderer))->create();
    }
}
