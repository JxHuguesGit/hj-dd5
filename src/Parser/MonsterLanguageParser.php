<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonsterLanguage as EntityRpgMonsterLanguage;
use src\Enum\LanguageEnum;
use src\Repository\RpgMonsterLanguage as RepositoryRpgMonsterLanguage;
use src\Repository\RpgLanguage as RepositoryRpgLanguage;

class MonsterLanguageParser extends AbstractMonsterParser
{
    private const PATTERN_SEPARATOR = "/[,;]/";

    protected function doParse(): bool
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='Languages']");
        if ($nodes->length === 0) {
            return false;
        }

        $node = $nodes->item(0);
        $content = trim($node->nextSibling->textContent ?? '');
        if ($content === '') {
            return false;
        }

        $hasChanged = false;
        $elements = preg_split(self::PATTERN_SEPARATOR, $content);

        foreach ($elements as $element) {
            $element = trim($element);
            if ($element === '') {
                continue;
            }

            if ($this->handleLanguage($element)) {
                $hasChanged = true;
            }
        }

        return $hasChanged;
    }

    private function handleLanguage(string $element): bool
    {
        $hasChanged = false;
        $monsterId = $this->rpgMonster->getField(Field::ID);
        $parts = preg_split('/\s+/', trim($element));

        // Format : "Primordial (aérien)" ou "Telepathy 120 ft."
        [$ability, $value, $unit] = array_pad($parts, 3, null);

        if ($unit === 'ft.') {
            $value = isset($value) ? (float)$value * self::FEET_TO_METERS : 0;
        } else {
            $ability = trim($ability.' '.$value);
            $value = 0;
        }

        $enum = LanguageEnum::fromEnglish($ability);
        if ($enum === null) {
            // Donnée non reconnue → on ne stocke rien
            return false;
        }

        $langRepo = new RepositoryRpgLanguage($this->queryBuilder, $this->queryExecutor);
        $linkRepo = new RepositoryRpgMonsterLanguage($this->queryBuilder, $this->queryExecutor);

        $objs = $langRepo->findBy([Field::NAME => $enum->label()]);
        $langObj = $objs->current();
        if ($langObj === null) {
            // Tu pourrais ici logger ou lever une alerte plutôt que d’afficher
            echo "[" . $enum->label() . "]";
            return false;
        }

        $languageId = $langObj->getField(Field::ID);
        $params = [Field::MONSTERID => $monsterId, Field::LANGUAGEID => $languageId];
        $existing = $linkRepo->findBy($params);

        if ($existing->isEmpty()) {
            $params[Field::ID] = 0;
            $params[Field::VALUE] = $value;
            $entity = new EntityRpgMonsterLanguage(...$params);
            $linkRepo->insert($entity);
            $hasChanged = true;
        }

        return $hasChanged;
    }

}
