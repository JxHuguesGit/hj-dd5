<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Feat;
use src\Domain\Entity\FeatType;
use src\Domain\Entity\PreRequis;
use src\Domain\Entity\Reference;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\PreRequisReader;
use src\Service\Reader\ReferenceReader;

final class FeatPreRequisService
{
    public function __construct(
        private FeatTypeReader $featTypeReader,
        private PreRequisReader $preRequisReader,
        private ReferenceReader $referenceReader,
    ) {}

    public function getReferenceForFeat(Feat $feat): ?Reference
    {
        return $this->referenceReader->referenceById($feat->sourceId);
    }

    /**
     * @return Collection<PreRequis>
     */
    public function preRequisForFeatWithType(Feat $feat): Collection
    {
        $preRequis = new Collection();

        $featType = $this->featTypeReader->featTypeById($feat->featTypeId);

        if ($featType?->preRequisId !== null) {
            $preRequisItem = $this->preRequisReader->preRequisById(
                $featType->preRequisId
            );

            if ($preRequisItem !== null) {
                $preRequis->add($preRequisItem);
            }
        }

        if ($feat->preRequisId !== null) {
            $preRequisItem = $this->preRequisReader->preRequisById(
                $feat->preRequisId
            );

            if ($preRequisItem !== null) {
                $preRequis->add($preRequisItem);
            }
        }

        return $preRequis;
    }

    public function preRequisForFeat(Feat $feat): ?PreRequis
    {
        if ($feat->preRequisId === null) {
            return null;
        }

        return $this->preRequisReader->preRequisById($feat->preRequisId);
    }

    public function preRequisForFeatType(FeatType $featType): ?PreRequis
    {
        if ($featType->preRequisId === null) {
            return null;
        }

        return $this->preRequisReader->preRequisById($featType->preRequisId);
    }
}
