<?php
namespace src\Parser;

use src\Constant\Field;
use src\Enum\ConditionEnum;
use src\Enum\DamageEnum;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\RpgMonsterCondition as EntityRpgMonsterCondition;
use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;
use src\Repository\RpgCondition as RepositoryRpgCondition;
use src\Repository\RpgMonsterCondition as RepositoryRpgMonsterCondition;
use src\Repository\RpgMonsterResistance as RepositoryRpgMonsterResistance;
use src\Repository\RpgTypeDamage as RepositoryRpgTypeDamage;

class MonsterResistancesParser extends AbstractMonsterParser
{
    const PATTERN_SEPARATOR = "/[,;]/";

    protected function doParse(): bool
    {
        $sections = [
            ['label' => 'Resistances',     'type' => 'R'],
            ['label' => 'Immunities',      'type' => 'I'],
            ['label' => 'Vulnerabilities', 'type' => 'V'],
        ];

        $hasChanged = false;

        foreach ($sections as $section) {
            if ($this->parseResistanceGroup($section['label'], $section['type'])) {
                $hasChanged = true;
            }
        }

        return $hasChanged;
    }

    /**
     * Parse une catégorie (Résistances / Immunités / Vulnérabilités)
     */
    private function parseResistanceGroup(string $label, string $type): bool
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='{$label}']");
        $node = $nodes->item(0);
        if (!$node) {
            return false;
        }

        $nextNode = $node->nextSibling;
        $content = trim($nextNode?->textContent ?? '');
        if ($content === '') {
            return false;
        }

        $rpgMonsterId = $this->rpgMonster->getField(Field::ID);
        $objDaoDamage = new RepositoryRpgTypeDamage($this->queryBuilder, $this->queryExecutor);
        $objDaoCond   = new RepositoryRpgCondition($this->queryBuilder, $this->queryExecutor);
        $objDaoJoin   = new RepositoryRpgMonsterResistance($this->queryBuilder, $this->queryExecutor);
        $objDaoJoinCond = new RepositoryRpgMonsterCondition($this->queryBuilder, $this->queryExecutor);

        $elements = preg_split(self::PATTERN_SEPARATOR, $content);
        $hasChanged = false;

        foreach ($elements as $element) {
            $element = trim($element);
            if ($element === '') {
                continue;
            }

            $enum = DamageEnum::fromEnglish($element);
            if ($enum !== null) {
                $hasChanged |= $this->handleDamageType($enum, $rpgMonsterId, $type, $objDaoDamage, $objDaoJoin);
                continue;
            }

            // Cas des immunités de conditions
            if ($type === 'I') {
                $enum = ConditionEnum::fromEnglish($element);
                if ($enum !== null) {
                    $hasChanged |= $this->handleConditionType($enum, $rpgMonsterId, $objDaoCond, $objDaoJoinCond);
                }
            }
        }

        return $hasChanged;
    }

    /**
     * Gère un type de dégât (DamageEnum)
     */
    private function handleDamageType(
        DamageEnum $enum,
        int $monsterId,
        string $type,
        RepositoryRpgTypeDamage $daoDamage,
        RepositoryRpgMonsterResistance $daoJoin
    ): bool {
        $objs = $daoDamage->findBy([Field::NAME => $enum->label()]);
        $obj = $objs->current();
        if (!$obj) {
            return false;
        }

        $typeDamageId = $obj->getField(Field::ID);
        $params = [
            Field::MONSTERID => $monsterId,
            Field::TYPEDMGID => $typeDamageId,
            Field::TYPERESID => $type,
        ];
        $existing = $daoJoin->findBy($params);

        if ($existing->isEmpty()) {
            $params[Field::ID] = 0;
            $daoJoin->insert(new EntityRpgMonsterResistance(...$params));
            return true;
        }

        return false;
    }

    /**
     * Gère un type de condition (ConditionEnum)
     */
    private function handleConditionType(
        ConditionEnum $enum,
        int $monsterId,
        RepositoryRpgCondition $daoCond,
        RepositoryRpgMonsterCondition $daoJoinCond
    ): bool {
        $objs = $daoCond->findBy([Field::NAME => $enum->label()]);
        $obj = $objs->current();
        if (!$obj) {
            return false;
        }

        $typeConditionId = $obj->getField(Field::ID);
        $params = [
            Field::MONSTERID => $monsterId,
            Field::CONDITIONID => $typeConditionId,
        ];
        $existing = $daoJoinCond->findBy($params);

        if ($existing->isEmpty()) {
            $params[Field::ID] = 0;
            $daoJoinCond->insert(new EntityRpgMonsterCondition(...$params));
            return true;
        }

        return false;
    }

}
