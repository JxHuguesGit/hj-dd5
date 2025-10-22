<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterTypeVision as EntityRpgMonsterTypeVision;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterTypeVision as RepositoryRpgMonsterTypeVision;
use src\Repository\RpgTypeVision as RepositoryRpgTypeVision;

class MonsterSensesParser extends AbstractMonsterParser
{
    
    protected function doParse(): bool
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Senses']");

        if ($nodes->length === 0) {
            return false;
        }

        $content = trim($nodes->item(0)->nextSibling?->textContent ?? '');
        if ($content === '') {
            return false;
        }

        $elements = array_filter(array_map('trim', explode(',', $content)));
        $hasChanged = false;

        foreach ($elements as $element) {
            if ($this->parseSense($element)) {
                $hasChanged = true;
            }
        }

        return $hasChanged;
    }

    private function parseSense(string $element): bool
    {
        $result = false;

        $parts = preg_split('/\s+/', trim($element));
        if (count($parts) < 2) {
            return $result;
        }

        // Exemple : "Darkvision 60 ft." ou "Passive Perception 11"
        if (isset($parts[2]) && $parts[2] === 'ft.') {
            $result = $this->handleVision($parts[0], $parts[1]);
        } elseif (
            strtolower($parts[0]) === 'passive' &&
            strtolower($parts[1]) === 'perception'
        ) {
            $result = $this->handlePassivePerception((int)($parts[2] ?? 0));
        } else {
            // Sonar
        }

        return $result;
    }

    private function handlePassivePerception(int $value): bool
    {
        $current = $this->rpgMonster->getField(Field::PERCPASSIVE);
        if ($current === $value) {
            return false;
        }

        $this->rpgMonster->setField(Field::PERCPASSIVE, $value);
        return true;
    }

    private function handleVision(string $type, string $distance): bool
    {
        $hasChanged = false;
        $type = strtolower($type);
        $value = (float)$distance * self::FEET_TO_METERS;

        $typeRepo = new RepositoryRpgTypeVision($this->queryBuilder, $this->queryExecutor);
        $linkRepo = new RepositoryRpgMonsterTypeVision($this->queryBuilder, $this->queryExecutor);

        $typeObj = $typeRepo->findBy([Field::UKTAG => $type])->current();
        if ($typeObj) {
            $typeId = $typeObj->getField(Field::ID);
            $monsterId = $this->rpgMonster->getField(Field::ID);
            $existing = $linkRepo->findBy([
                Field::MONSTERID => $monsterId,
                Field::TYPEVISIONID => $typeId
            ]);

            if ($existing->isEmpty()) {
                $entity = new EntityRpgMonsterTypeVision(0, $monsterId, $typeId, $value, '');
                $linkRepo->insert($entity);
                $hasChanged = true;
            } else {
                $entity = $existing->current();
                $storedValue = $entity->getField(Field::VALUE);

                if ($storedValue !== $value) {
                    $entity->setField(Field::VALUE, $value);
                    $linkRepo->update($entity);
                    $hasChanged = true;
                }
            }
        }

        return $hasChanged;
    }
}
