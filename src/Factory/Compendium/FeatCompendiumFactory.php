<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\FeatCompendiumHandler;
use src\Presenter\ToastBuilder;
use src\Repository\AbilityRepository;
use src\Repository\FeatAbilityRepository;
use src\Repository\FeatRepository;
use src\Repository\FeatTypeRepository;
use src\Repository\OriginRepository;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\OriginReader;
use src\Service\Writer\FeatWriter;

class FeatCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): FeatCompendiumHandler
    {
        return new FeatCompendiumHandler(
            $this->writer(FeatWriter::class, FeatRepository::class),
            $this->reader(FeatReader::class, FeatRepository::class),
            $this->reader(FeatTypeReader::class, FeatTypeRepository::class),
            $this->reader(OriginReader::class, OriginRepository::class),
            $this->reader(FeatAbilityReader::class, FeatAbilityRepository::class),
            $this->reader(AbilityReader::class, AbilityRepository::class),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}
