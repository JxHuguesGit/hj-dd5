<?php
namespace src\Repository;

use src\Constant\Field;
use src\Entity\Entity;
use src\Entity\RpgHeros as EntityRpgHeros;

class RpgHeros extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHeros::class;
    }

    public function delete(Entity $hero): void
    {
        // supprimer feats
        (new RpgHerosFeat($this->queryBuilder, $this->queryExecutor))
            ->deleteBy([Field::HEROSID => $hero->getId()]);

        // supprimer skills
        (new RpgHerosSkill($this->queryBuilder, $this->queryExecutor))
            ->deleteBy([Field::HEROSID => $hero->getId()]);

        // supprimer classes
        (new RpgHerosClasse($this->queryBuilder, $this->queryExecutor))
            ->deleteBy([Field::HEROSID => $hero->getId()]);

        parent::delete($hero);
    }
}
