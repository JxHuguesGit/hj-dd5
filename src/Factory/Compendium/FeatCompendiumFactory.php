<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\FeatCompendiumHandler;
use src\Presenter\ToastBuilder;
use src\Repository\{FeatRepository, FeatTypeRepository, OriginRepository};
use src\Service\Reader\{FeatReader, FeatTypeReader, OriginReader};

class FeatCompendiumFactory extends AbstractCompendiumFactory
{
    public function create(): FeatCompendiumHandler
    {
        return new FeatCompendiumHandler(
            $this->writer(FeatReader::class, FeatRepository::class),
            $this->reader(FeatReader::class, FeatRepository::class),
            $this->reader(FeatTypeReader::class, FeatTypeRepository::class),
            $this->reader(OriginReader::class, OriginRepository::class),
            new ToastBuilder($this->renderer),
            $this->renderer
        );
    }
}

