<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table as T;
use src\Domain\Criteria\SpellCriteria;
use src\Domain\Entity\Classe;
use src\Domain\Entity\Spell;
use src\Query\QueryBuilder;

class SpellRepository extends Repository implements SpellRepositoryInterface
{
    public const TABLE = T::SPELL;
    
    public function getEntityClass(): string
    {
        return Spell::class;
    }

    /**
     * @return ?Spell
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Spell
    {
        $criteria = new SpellCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Spell>
     */
    public function findAllWithRelations(SpellCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT s." . F::ID . ", s." . F::WPPOSTID . ", s." . F::SOURCEID . ", s." . F::SCHOOLID . ", s." . F::CASTINGTIMEID . ",
                s." . F::RANGEID . ", s." . F::DURATIONID . ", s." . F::SPELLENHANCEMENTID . ", s." . F::SPELLTRIGGERID . ", s." . F::MATERIALCOMPID . ",
                s." . F::LEVEL . ", s." . F::RITUEL . ", s." . F::CONCENTRATION . ", s." . F::COMPONENTS . ",
                wp.post_title AS " . F::NAME . ", wp.post_name AS " . F::SLUG . ", wp.post_content AS " . F::DESCRIPTION . ",
                rss." . F::NAME . " AS " . F::SCHOOLNAME . ",
                rsr." . F::NAME . " AS " . F::RANGENAME . ",
                rsd." . F::NAME . " AS " . F::DURATIONNAME . ",
                rsct." . F::NAME . " AS " . F::CASTINGTIMENAME . ",
                rmc." . F::DESCRIPTION . " AS " . F::MATERIALCOMPNAME . ",
                rr." . F::NAME . " AS " . F::SOURCENAME . ",
                rr." . F::CODE . " AS " . F::SOURCECODE . "
            FROM " . self::TABLE . " s "
            . T::LEFTJOIN . T::WPPOST . " wp ON s." . F::WPPOSTID . " = wp.ID "
            . T::LEFTJOIN . T::SPELLSCHOOL . " rss ON rss.id = s." . F::SCHOOLID . " "
            . T::LEFTJOIN . T::SPELLRANGE . " rsr ON rsr.id = s." . F::RANGEID . " "
            . T::LEFTJOIN . T::SPELLDURATION . " rsd ON rsd.id = s." . F::DURATIONID . " "
            . T::LEFTJOIN . T::SPELLCASTINGTIME . " rsct ON rsct.id = s." . F::CASTINGTIMEID . " "
            . T::LEFTJOIN . T::MATERIALCOMPONENT . " rmc ON rmc.id = s." . F::MATERIALCOMPID . " "
            . T::LEFTJOIN . T::REFERENCE . " rr ON rr.id = s." . F::SOURCEID . "
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);
        $criteria->join($queryBuilder);
        $criteria->apply($queryBuilder);

        $this->query = $queryBuilder->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $queryBuilder->getParams()
        );
    }

    /**
     * @return Collection<Classe>
     */
    public function classesBySpellId(int $spellId): Collection
    {
        $baseQuery = "
            SELECT " . F::NAME . ", " . F::SKILLS . ", " . F::CODE . "
            FROM " . T::RPGCLASSE . " c
                LEFT JOIN " . T::SPELLCLASSE . " rsc ON c.id = rsc." . F::CLASSEID . "
            WHERE `" . F::SPELLID . "` = " . $spellId . "
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);

        $this->query = $queryBuilder->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            Classe::class
        );
    }
}
