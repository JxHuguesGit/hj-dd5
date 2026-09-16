<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SkillCompendiumHandler;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Renderer\TemplateRenderer;
use src\Repository\SkillRepository;
use src\Service\Reader\SkillReader;

class SkillCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SkillCompendiumHandler
    {
        return new SkillCompendiumHandler(
            $this->reader(SkillReader::class, SkillRepository::class),
            new SkillListPresenter(
                $this->reader(SkillReader::class, SkillRepository::class),
            ),
            new TemplateRenderer()
        );
    }
}
