<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterTypeSpeed as EntityRpgMonsterTypeSpeed;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterTypeSpeed as RepositoryRpgMonsterTypeSpeed;
use src\Repository\RpgTypeSpeed as RepositoryRpgTypeSpeed;

class MonsterSpeedParser
{
    private const FEET_TO_METERS = 0.3;

    protected QueryBuilder $queryBuilder;
    protected QueryExecutor $queryExecutor;
    protected RpgMonster $rpgMonster;
    protected \DOMDocument $dom;
    
    public function __construct(QueryBuilder $queryBuilder, QueryExecutor $queryExecutor, RpgMonster $rpgMonster, \DOMDocument $dom)
    {
        $this->queryBuilder  = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
        $this->rpgMonster    = $rpgMonster;
        $this->dom           = $dom;
    }

    public static function parseSpeed(RpgMonster &$rpgMonster, \DOMDocument $dom): bool
    {
        $parser = new self(new QueryBuilder(), new QueryExecutor(), $rpgMonster, $dom);
        return $parser->doParse();
    }

    public function doParse(): bool
    {
        $nodes = (new \DOMXPath($this->dom))->query("//strong[normalize-space(text())='Speed']");
        $canProceed = $nodes->length > 0;
        
        if ($canProceed) {
            $speedNode = $nodes->item(0);
            $canProceed = $speedNode && $speedNode->nextSibling;
        }

        if ($canProceed) {
            $speedValue = trim($speedNode->nextSibling->textContent);
            $canProceed = $speedValue !== '';
        }

        if ($canProceed) {
            preg_match_all('/([A-Za-z]+)?\s*(\d+)\s*ft\.?(?:\s*\((.*?)\))?/', $speedValue, $matches, PREG_SET_ORDER);
            $canProceed = !empty($matches);
        }

        $blnHasChanged = false;
        if ($canProceed) {
            $standard = (float) $matches[0][2] * self::FEET_TO_METERS;
            if ($this->rpgMonster->getField(Field::VITESSE) !== $standard) {
                $this->rpgMonster->setField(Field::VITESSE, $standard);
                $blnHasChanged = true;
            }
        
            $this->processExtraSpeeds(array_slice($matches, 1));
        }
        return $blnHasChanged;
    }

    private function processExtraSpeeds(array $matches): void
    {
        $objDaoTS  = new RepositoryRpgTypeSpeed($this->queryBuilder, $this->queryExecutor);
        $objDaoJMTS = new RepositoryRpgMonsterTypeSpeed($this->queryBuilder, $this->queryExecutor);
        $monsterId  = $this->rpgMonster->getField(Field::ID);

        foreach ($matches as $m) {
            [, $type, $value, $extra] = $m;
            $type = strtolower(trim($type ?: 'walk'));
            $value = (float) $value * self::FEET_TO_METERS;
            $extra = trim($extra ?? '');

            $objs = $objDaoTS->findBy([Field::UKTAG => $type]);
            $obj = $objs->current();
            if (!$obj) {
                continue;
            }

            $typeSpeedId = $obj->getField(Field::ID);
            $existing = $objDaoJMTS->findBy([
                Field::MONSTERID   => $monsterId,
                Field::TYPESPEEDID => $typeSpeedId
            ])->current();

            if (!$existing) {
                $objDaoJMTS->insert(new EntityRpgMonsterTypeSpeed(0, $monsterId, $typeSpeedId, $value, $extra));
                continue;
            }

            $this->updateIfChanged($objDaoJMTS, $existing, Field::VALUE, $value);
            $this->updateIfChanged($objDaoJMTS, $existing, Field::EXTRA, $extra);
        }
    }

    private function updateIfChanged(RepositoryRpgMonsterTypeSpeed $repo, $entity, string $field, $newValue): void
    {
        if ($entity->getField($field) !== $newValue) {
            $entity->setField($field, $newValue);
            $repo->update($entity);
        }
    }
}
