<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class Hero extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'mmorpgHeroes',
            [Field::ID, Field::NAME, Field::CASTEID, Field::WPUSERID, Field::LASTUPDATE, Field::CREATESTEP]
        );
    }

    public function getNextName(string $userNicename): string
    {
        $collection = $this->findBy([Field::NAME=>$userNicename]);
        if ($collection->valid()) {
            $cpt = 1;
            do {
                $testName = $userNicename.$cpt;
                $collection = $this->findBy([Field::NAME=>$testName]);
                ++$cpt;
            } while ($collection->valid());
            $userNicename = $testName;
        }
        return $userNicename;
    }

}
