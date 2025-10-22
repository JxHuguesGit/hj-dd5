<?php
namespace src\Parser;

use src\Constant\Field;
use src\Entity\RpgMonster;
use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;

class MonsterActionsParser
{
    private const PATTERN_ACTION = "/<p><strong><em>([^<]+)<\/em><\/strong>\. (.+)<\/p>/s";
    private const TYPE_ACTIONS = [
        'A' => 'Actions',
        'T' => 'Traits',
        'B' => 'Bonus actions',
        'R' => 'Reactions',
        'L' => 'Legendary actions',
    ];

    private QueryBuilder $queryBuilder;
    private QueryExecutor $queryExecutor;
    private RpgMonster $rpgMonster;
    private \DOMDocument $dom;
    private RepositoryRpgMonsterAbility $abilityRepo;

    public function __construct(
        QueryBuilder $queryBuilder,
        QueryExecutor $queryExecutor,
        RpgMonster $rpgMonster,
        \DOMDocument $dom
    ) {
        $this->queryBuilder  = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
        $this->rpgMonster    = $rpgMonster;
        $this->dom           = $dom;
    }

    public static function parse(RpgMonster $rpgMonster, \DOMDocument $dom): bool
    {
        $parser = new self(new QueryBuilder(), new QueryExecutor(), $rpgMonster, $dom);
        return $parser->doParse();
    }

    private function doParse(): bool
    {
        $xpath = new \DOMXPath($this->dom);
        $hasChanged = false;
        $this->abilityRepo = new RepositoryRpgMonsterAbility($this->queryBuilder, $this->queryExecutor);

        foreach (self::TYPE_ACTIONS as $typeId => $typeName) {
            $nodes = $xpath->query("//div[@class='rub' and normalize-space()='$typeName']");
            $node = $nodes->item(0);
            if ($node !== null) {
                if ($this->parseSection($typeId, $node)) {
                    $hasChanged = true;
                }
            }
        }

        return $hasChanged;
    }

    private function parseSection(string $typeId, \DOMNode $node): bool
    {
        $hasChanged = false;
        $current = $node->nextSibling;
        $monsterId = $this->rpgMonster->getField(Field::ID);

        while ($current) {
            // Fin de section
            if ($this->isNewSection($current)) {
                break;
            }

            // En-tête de légendaire
            if ($this->isLegendHeader($current)) {
                $this->insertLegendaryHeader($typeId, $monsterId, $current);
                $current = $current->nextSibling;
                $hasChanged = true;
                continue;
            }

            // Action classique (<p><strong><em>Nom</em></strong>. Description</p>)
            if ($this->isParagraphAction($current)) {
                $hasChanged = $this->handleParagraphAction($typeId, $monsterId, $current) || $hasChanged;
                $current = $current->nextSibling;
                continue;
            }

            // Format brut séparé par <br> (cas "Detect Life.<br>")
            if ($this->isRawText($current)) {
                $hasChanged = $this->handleRawTextBlock($typeId, $monsterId, $current) || $hasChanged;
                $current = $this->skipUntilNextSection($current);
                continue;
            }

            $current = $current->nextSibling;
        }

        return $hasChanged;
    }

    /** ──────────────────────────── Helpers ──────────────────────────── */

    private function isNewSection(\DOMElement|\DOMNode $node): bool
    {
        return
            $node->nodeType === XML_ELEMENT_NODE &&
            $node->nodeName === 'div' &&
            $node->getAttribute('class') === 'rub';
    }

    private function isLegendHeader(\DOMElement|\DOMNode $node): bool
    {
        return
            $node->nodeType === XML_ELEMENT_NODE &&
            $node->nodeName === 'div' &&
            $node->getAttribute('class') === 'legend';
    }

    private function insertLegendaryHeader(string $typeId, int $monsterId, \DOMNode $node): void
    {
        $params = [
            Field::TYPEID => $typeId,
            Field::MONSTERID => $monsterId,
            Field::NAME => 'legend',
        ];
        $objs = $this->abilityRepo->findBy($params);

        if (!$objs->isEmpty()) {
            return;
        }

        $params[Field::ID] = 0;
        $params[Field::DESCRIPTION] = trim($node->textContent);
        $params[Field::RANK] = 0;

        $obj = new EntityRpgMonsterAbility(...$params);
        $this->abilityRepo->insert($obj);
    }

    private function isParagraphAction(\DOMNode $node): bool
    {
        if ($node->nodeType !== XML_ELEMENT_NODE || $node->nodeName !== 'p') {
            return false;
        }
        $html = trim($this->dom->saveHTML($node));
        return (bool)preg_match(self::PATTERN_ACTION, $html);
    }

    private function handleParagraphAction(string $typeId, int $monsterId, \DOMNode $node): bool
    {
        $html = trim($this->dom->saveHTML($node));
        if (!preg_match(self::PATTERN_ACTION, $html, $matches)) {
            return false;
        }

        $params = [
            Field::TYPEID => $typeId,
            Field::MONSTERID => $monsterId,
            Field::NAME => $matches[1],
        ];

        $existing = $this->abilityRepo->findBy($params);
        if (!$existing->isEmpty()) {
            return false;
        }

        $params[Field::ID] = 0;
        $params[Field::DESCRIPTION] = $matches[2];
        $params[Field::RANK] = 0;
        $obj = new EntityRpgMonsterAbility(...$params);
        $this->abilityRepo->insert($obj);
        return true;
    }

    private function isRawText(\DOMNode $node): bool
    {
        return
            $node->nodeType === XML_TEXT_NODE ||
            ($node->nodeType === XML_ELEMENT_NODE && in_array($node->nodeName, ['br', 'text']));
    }

    private function handleRawTextBlock(string $typeId, int $monsterId, \DOMNode $start): bool
    {
        $hasChanged = false;
        $raw = '';
        $scan = $start;

        while ($scan && !$this->isNewSection($scan)) {
            $raw .= $this->dom->saveHTML($scan);
            $scan = $scan->nextSibling;
        }

        $lines = preg_split('/<br\s*\/?>/i', $raw);
        foreach ($lines as $line) {
            $line = trim(strip_tags($line));
            if ($line === '') {
                continue;
            }

            $name = rtrim($line, '.');
            $params = [
                Field::TYPEID => $typeId,
                Field::MONSTERID => $monsterId,
                Field::NAME => $name,
            ];

            $existing = $this->abilityRepo->findBy($params);
            if ($existing->isEmpty()) {
                $params[Field::ID] = 0;
                $params[Field::DESCRIPTION] = '';
                $params[Field::RANK] = 0;
                $obj = new EntityRpgMonsterAbility(...$params);
                $this->abilityRepo->insert($obj);
                $hasChanged = true;
            }
        }

        return $hasChanged;
    }

    private function skipUntilNextSection(\DOMNode $node): ?\DOMNode
    {
        $scan = $node;
        while ($scan && !$this->isNewSection($scan)) {
            $scan = $scan->nextSibling;
        }
        return $scan;
    }
}
