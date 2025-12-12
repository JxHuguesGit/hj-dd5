<?php
namespace src\Repository;

use src\Entity\RpgFeatSelection as EntityRpgFeatSelection;

class RpgFeatSelection extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgFeatSelection::class;
    }
}
