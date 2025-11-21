<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterLanguage as ControllerRpgMonsterLanguage;
use src\Entity\RpgLanguage as EntityRpgLanguage;
use src\Repository\RpgLanguage;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterLanguage extends Entity
{
    public const TABLE = 'rpgMonsterLanguage';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::LANGUAGEID,
        Field::VALUE,
    ];

    protected int $monsterId;
    protected string $languageId;
    protected float $value;
    
    public function getController(): ControllerRpgMonsterLanguage
    {
        $obj = new ControllerRpgMonsterLanguage();
        $obj->setField(self::TABLE, $this);
        return $obj;
    }

    public function getLanguage(): ?EntityRpgLanguage
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgLanguage($queryBuilder, $queryExecutor);
        return $objDao->find($this->languageId);
    }
}
