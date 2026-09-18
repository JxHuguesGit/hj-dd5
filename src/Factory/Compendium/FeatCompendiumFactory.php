<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\FeatCompendiumHandler;
use src\Presenter\FormBuilder\FeatFormBuilder;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\ToastBuilder;
use src\Service\Domain\WpPostService;

class FeatCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): FeatCompendiumHandler
    {
        $featTypeReader = $this->readerFactory->featType();
        $originReader = $this->readerFactory->origin();
        $abilityReader = $this->readerFactory->ability();
        $featAbilityReader = $this->readerFactory->featAbility();
        $referenceReader = $this->readerFactory->reference();
        $preRequisReader = $this->readerFactory->preRequis();
        $featPrerequisiteService = $this->serviceFactory->featPreRequis();

        return new FeatCompendiumHandler(
            $this->writerFactory->feat(),
            $this->writerFactory->featAbility(),
            $this->readerFactory->feat(),
            $featAbilityReader,
            $abilityReader,
            $featPrerequisiteService,
            $preRequisReader,
            $this->writerFactory->featPreRequis(),
            new ToastBuilder($this->renderer),
            $this->renderer,
            new FeatFormBuilder(
                new WpPostService(),
                $featTypeReader,
                $abilityReader,
                $featAbilityReader,
                $referenceReader,
                $preRequisReader,
                $featPrerequisiteService,
            ),
            new FeatListPresenter(
                $originReader,
                $featPrerequisiteService,
                $featTypeReader,
                $referenceReader,
                $featAbilityReader,
                $abilityReader
            )
        );
    }
}
