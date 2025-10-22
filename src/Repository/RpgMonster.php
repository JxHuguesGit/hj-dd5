<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonster extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgMonster',
            [Field::ID, Field::FRNAME, Field::NAME, Field::FRTAG, Field::UKTAG, Field::INCOMPLET, Field::SCORECR, Field::MSTTYPEID, Field::MSTSSTYPID
            , Field::SWARMSIZE, Field::MSTSIZE, Field::SCORECA, Field::SCOREHP, Field::ALGNID, Field::LEGENDARY, Field::HABITAT, Field::REFID, Field::EXTRA
            , Field::VITESSE, Field::INITIATIVE, Field::STRSCORE, Field::DEXSCORE, Field::CONSCORE, Field::INTSCORE, Field::WISSCORE, Field::CHASCORE
            , Field::PROFBONUS, Field::PERCPASSIVE]
        );
    }

}
