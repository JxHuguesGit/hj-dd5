<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\FeatCompendiumHandler;
use src\Presenter\ToastBuilder;
use src\Repository\AbilityRepository;
use src\Repository\FeatAbilityRepository;
use src\Repository\FeatPreRequisRepository;
use src\Repository\FeatRepository;
use src\Repository\FeatTypeRepository;
use src\Repository\OriginRepository;
use src\Repository\PreRequisRepository;
use src\Repository\ReferenceRepository;
use src\Service\Domain\FeatPreRequisService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatPreRequisReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\PreRequisReader;
use src\Service\Reader\ReferenceReader;
use src\Service\Writer\FeatAbilityWriter;
use src\Service\Writer\FeatPreRequisWriter;
use src\Service\Writer\FeatWriter;

class FeatCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): FeatCompendiumHandler
    {
        return new FeatCompendiumHandler(
            $this->writer(FeatWriter::class, FeatRepository::class),
            $this->writer(FeatAbilityWriter::class, FeatAbilityRepository::class),
            $this->reader(FeatReader::class, FeatRepository::class),
            $this->reader(FeatTypeReader::class, FeatTypeRepository::class),
            $this->reader(OriginReader::class, OriginRepository::class),
            $this->reader(FeatAbilityReader::class, FeatAbilityRepository::class),
            $this->reader(AbilityReader::class, AbilityRepository::class),
            $this->reader(ReferenceReader::class, ReferenceRepository::class),
            new FeatPreRequisService(
                $this->reader(FeatTypeReader::class, FeatTypeRepository::class),
                $this->reader(PreRequisReader::class, PreRequisRepository::class),
                $this->reader(FeatPreRequisReader::class, FeatPreRequisRepository::class),
                $this->reader(ReferenceReader::class, ReferenceRepository::class)
            ),
            $this->reader(PreRequisReader::class, PreRequisRepository::class),
            $this->writer(FeatPreRequisWriter::class, FeatPreRequisRepository::class),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}
