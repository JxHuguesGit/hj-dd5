<?php
namespace src\Parser;

use src\Constant\Constant;
use src\Constant\Field;
use src\Utils\Utils;

class MonsterCaracsParser extends AbstractMonsterParser
{
    protected function doParse(): bool
    {
        $hasChanged = false;

        $sections = [
            'physiques' => [
                'xpath' => "//div[contains(@class, 'car2') or contains(@class, 'car3')]",
                Constant::CST_ABILITIES => [
                    ['score' => Field::STRSCORE, 'jsonCar' => 'carstr', 'jsonSave' => 'jsstr'],
                    ['score' => Field::DEXSCORE, 'jsonCar' => 'cardex', 'jsonSave' => 'jsdex'],
                    ['score' => Field::CONSCORE, 'jsonCar' => 'carcon', 'jsonSave' => 'jscon'],
                ],
            ],
            'mentales' => [
                'xpath' => "//div[contains(@class, 'car5') or contains(@class, 'car6')]",
                Constant::CST_ABILITIES => [
                    ['score' => Field::INTSCORE, 'jsonCar' => 'carint', 'jsonSave' => 'jsint'],
                    ['score' => Field::WISSCORE, 'jsonCar' => 'carwis', 'jsonSave' => 'jswis'],
                    ['score' => Field::CHASCORE, 'jsonCar' => 'carcha', 'jsonSave' => 'jscha'],
                ],
            ],
        ];

        foreach ($sections as $config) {
            if ($this->parseCaracSection($config['xpath'], $config[Constant::CST_ABILITIES])) {
                $hasChanged = true;
            }
        }

        return $hasChanged;
    }
    
    /**
     * Parse une section de caractéristiques (physiques ou mentales)
     */
    private function parseCaracSection(string $xpathQuery, array $abilities): bool
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query($xpathQuery);

        $values = array_map(fn($n) => trim($n->textContent), iterator_to_array($nodes));
        if (count($values) !== 9) {
            return false;
        }

        $extra = json_decode($this->rpgMonster->getField(Field::EXTRA), true) ?: [];
        $hasChanged = false;

        foreach ($abilities as $i => $ability) {
            $offset = $i * 3;
            $score   = (int)$values[$offset];
            $carMod  = $this->normalizeValue($values[$offset + 1]);
            $saveMod = $this->normalizeValue($values[$offset + 2]);

            $hasChanged |= $this->updateAbility($ability['score'], $score);
            $hasChanged |= $this->updateJsonMods($extra, $ability, $score, $carMod, $saveMod);
        }

        if ($hasChanged) {
            $this->rpgMonster->setField(Field::EXTRA, json_encode($extra, JSON_UNESCAPED_UNICODE));
        }

        return $hasChanged;
    }

    /**
     * Nettoie les symboles + et – et convertit en int
     */
    private function normalizeValue(string $value): int
    {
        return (int)str_replace(['+', '–'], ['', '-'], $value);
    }
    
    /**
     * Met à jour un score principal si besoin
     */
    private function updateAbility(string $field, int $value): bool
    {
        if ($this->rpgMonster->getField($field) !== $value) {
            $this->rpgMonster->setField($field, $value);
            return true;
        }
        return false;
    }

    /**
     * Met à jour les bonus/malus enregistrés dans le JSON
     */
    private function updateJsonMods(array &$json, array $ability, int $score, int $carMod, int $saveMod): bool
    {
        $hasChanged = false;
        $baseMod = Utils::getModAbility($score);

        if ($baseMod !== $carMod) {
            $json[$ability['jsonCar']] = $carMod - $baseMod;
            $hasChanged = true;
        }

        if ($baseMod !== $saveMod) {
            $json[$ability['jsonSave']] = $saveMod - $baseMod;
            $hasChanged = true;
        }

        return $hasChanged;
    }
}
