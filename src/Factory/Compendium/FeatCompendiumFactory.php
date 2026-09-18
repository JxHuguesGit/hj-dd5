<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\FeatCompendiumHandler;
use src\Presenter\ToastBuilder;

class FeatCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): FeatCompendiumHandler
    {
        return new FeatCompendiumHandler(
            $this->writerFactory->feat(),
            $this->writerFactory->featAbility(),
            $this->readerFactory->feat(),
            $this->readerFactory->featType(),
            $this->readerFactory->origin(),
            $this->readerFactory->featAbility(),
            $this->readerFactory->ability(),
            $this->readerFactory->reference(),
            $this->serviceFactory->featPreRequis(),
            $this->readerFactory->preRequis(),
            $this->writerFactory->featPreRequis(),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}
