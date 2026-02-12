<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonsterTypeSpeed as EntityRpgMonsterTypeSpeed;
use src\Repository\RpgMonsterTypeSpeed as RepositoryRpgMonsterTypeSpeed;
use src\Repository\RpgTypeSpeed as RepositoryRpgTypeSpeed;

class MonsterSpeedParser extends AbstractMonsterParser
{
    protected function doParse(): bool
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
            if ($this->rpgMonster->getField(Field::SPEED) !== $standard) {
                $this->rpgMonster->setField(Field::SPEED, $standard);
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

    private function updateIfChanged(RepositoryRpgMonsterTypeSpeed $repo, EntityRpgMonsterTypeSpeed $entity, string $field, $newValue): void
    {
        if ($entity->getField($field) !== $newValue) {
            $entity->setField($field, $newValue);
            $repo->update($entity);
        }
    }
}
