<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Feat;
use src\Domain\Entity\FeatType;
use src\Domain\Entity\PreRequis;
use src\Domain\Entity\Reference;
use src\Presenter\ViewModel\FeatPreRequisResult;
use src\Service\Reader\FeatPreRequisReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\PreRequisReader;
use src\Service\Reader\ReferenceReader;

final class FeatPreRequisService
{
    public function __construct(
        private FeatTypeReader $featTypeReader,
        private PreRequisReader $preRequisReader,
        private FeatPreRequisReader $featPreRequisReader,
        private ReferenceReader $referenceReader,
    ) {}

    public function getFeatPreRequisReader(): FeatPreRequisReader
    {
        return $this->featPreRequisReader;
    }

    public function getReferenceForFeat(Feat $feat): ?Reference
    {
        return $this->referenceReader->referenceById($feat->sourceId);
    }

    /**
     * @return FeatPreRequisResult
     */
    public function preRequisForFeatWithType(Feat $feat): FeatPreRequisResult
    {
        $featTypePreRequis = null;

        $featType = $this->featTypeReader->featTypeById($feat->featTypeId);

        if ($featType !== null) {
            $featTypePreRequis = $this->preRequisForFeatType($featType);
        }

        return new FeatPreRequisResult(
            featType: $featTypePreRequis,
            feat: $this->preRequisForFeat($feat),
        );
    }

    /**
     * @return Collection<PreRequis>
     */
    public function preRequisForFeat(Feat $feat): Collection
    {
        $preRequis = new Collection();

        foreach (
            $this->featPreRequisReader->featPreRequisByFeatId($feat->id)
            as $featPreRequis
        ) {
            $preRequisItem = $this->preRequisReader->preRequisById(
                $featPreRequis->preRequisId
            );

            if ($preRequisItem !== null) {
                $preRequis->add($preRequisItem);
            }
        }

        return $preRequis;
    }

    public function preRequisForFeatType(FeatType $featType): ?PreRequis
    {
        if ($featType->preRequisId === null) {
            return null;
        }

        return $this->preRequisReader->preRequisById($featType->preRequisId);
    }
}
