<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\SkillCompendiumHandler;
use src\Presenter\ListPresenter\SkillListPresenter;

class SkillCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): SkillCompendiumHandler
    {
        return new SkillCompendiumHandler(
            $this->readerFactory->skill(),
            new SkillListPresenter(
                $this->readerFactory->skill(),
            ),
            $this->renderer
        );
    }
}
