<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonsterSkill as EntityRpgMonsterSkill;
use src\Enum\SkillEnum;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgMonsterSkill as RepositoryRpgMonsterSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;
use src\Utils\Utils;

class RpgMonster extends AbstractMonsterParser
{
    const PATTERN_SEPARATOR = "/[,;]/";

    protected function doParse(): bool
    {
        $hasChanged = false;

        $hasChanged |= $this->parseHitDice();
        $hasChanged |= MonsterSpeedParser::parse($this->rpgMonster, $this->dom);
        $hasChanged |= MonsterCaracsParser::parse($this->rpgMonster, $this->dom);
        $hasChanged |= $this->parseCrBm();
        $hasChanged |= $this->parseInitiative();
        $hasChanged |= MonsterSensesParser::parse($this->rpgMonster, $this->dom);

        MonsterLanguageParser::parse($this->rpgMonster, $this->dom);
        $this->parseSkills();
        MonsterResistancesParser::parse($this->rpgMonster, $this->dom);
        MonsterActionsParser::parse($this->rpgMonster, $this->dom);

        // Initialise EXTRA si vide
        if ($this->rpgMonster->getField(Field::EXTRA) === '') {
            $this->rpgMonster->setField(Field::EXTRA, json_encode([], JSON_UNESCAPED_UNICODE));
            $hasChanged = true;
        }

        // Mise à jour si modification
        if ($hasChanged) {
            (new RepositoryRpgMonster($this->queryBuilder, $this->queryExecutor))
                ->update($this->rpgMonster);
        }

        return $hasChanged;
    }

    // -------------------------------------------------------------
    // UTILITAIRES DE PARSING
    // -------------------------------------------------------------

    private function getTextAfterLabel(string $label): ?string
    {
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//strong[normalize-space(text())='{$label}']");
        if ($nodes->length === 0) {
            return null;
        }

        $next = $nodes->item(0)->nextSibling;
        return trim($next?->textContent ?? '');
    }

    private function updateIfChanged(string $field, mixed $newValue): bool
    {
        $oldValue = $this->rpgMonster->getField($field);
        if ($oldValue != $newValue) {
            $this->rpgMonster->setField($field, $newValue);
            return true;
        }
        return false;
    }

    // -------------------------------------------------------------
    // MÉTHODES DE PARSING SPÉCIFIQUES
    // -------------------------------------------------------------

    private function parseInitiative(): bool
    {
        $text = $this->getTextAfterLabel('Initiative');
        if (!$text) {
            return false;
        }

        [$score] = explode(' ', $text);
        $score = str_replace('+', '', $score);
        return $this->updateIfChanged(Field::INITIATIVE, $score);
    }

    private function parseCrBm(): bool
    {
        $text = $this->getTextAfterLabel('CR');
        if (!$text) {
            return false;
        }

        if (preg_match('/(.*) \(.*PB \+(\d*)/', $text, $matches)) {
            $cr = Utils::getUnformatCr($matches[1]);
            $pb = $matches[2];

            $changed = false;
            $changed |= $this->updateIfChanged(Field::SCORECR, $cr);
            $changed |= $this->updateIfChanged(Field::PROFBONUS, $pb);
            return $changed;
        }
        return false;
    }

    private function parseHitDice(): bool
    {
        $text = $this->getTextAfterLabel('HP');
        if (!$text || !preg_match('/\(([^)]+)\)/', $text, $matches)) {
            return false;
        }

        $value = '(' . $matches[1] . ')';
        $extra = json_decode($this->rpgMonster->getField(Field::EXTRA), true) ?: [];
        $stored = $extra['hp'] ?? null;

        if ($stored !== $value) {
            $extra['hp'] = $value;
            $this->rpgMonster->setField(Field::EXTRA, json_encode($extra, JSON_UNESCAPED_UNICODE));
            return true;
        }
        return false;
    }
    
    private function parseSkills(): void
    {
        $text = $this->getTextAfterLabel('Skills');
        if (!$text) {
            return;
        }

        $skills = explode(',', $text);
        $monsterId = $this->rpgMonster->getField(Field::ID);
        $daoSkill = new RepositoryRpgSkill($this->queryBuilder, $this->queryExecutor);
        $daoJoin  = new RepositoryRpgMonsterSkill($this->queryBuilder, $this->queryExecutor);

        foreach ($skills as $entry) {
            if (!str_contains($entry, '+')) {
                continue;
            }

            [$name, $bonus] = array_map('trim', explode('+', $entry));
            $bonus = (int)$bonus;

            $enum = SkillEnum::fromEnglish($name);
            if (!$enum) {
                continue;
            }

            $skillObjs = $daoSkill->findBy([Field::NAME => $enum->label()]);
            $skill = $skillObjs->current();
            if (!$skill) {
                continue;
            }

            $params = [
                Field::MONSTERID => $monsterId,
                Field::SKILLID   => $skill->getField(Field::ID)
            ];
            $joins = $daoJoin->findBy($params);

            if ($joins->isEmpty()) {
                $params[Field::ID] = 0;
                $params[Field::VALUE] = $bonus;
                $daoJoin->insert(new EntityRpgMonsterSkill(...$params));
            } else {
                $join = $joins->current();
                if ($join->getField(Field::VALUE) != $bonus) {
                    $join->setField(Field::VALUE, $bonus);
                    $daoJoin->update($join);
                }
            }
        }
    }

}
