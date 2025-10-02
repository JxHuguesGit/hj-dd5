<?php
namespace src\Query;

use src\Entity\Entity;

class QueryBuilder
{
    private string $baseQuery = '';
    private string $strWhere = '';
    private string $strOrderBy = '';
    private string $strLimit = '';
    private array $params = [];
    
    public function select(array $fields, string $table): self
    {
        $this->baseQuery = "SELECT `".implode("`, `", $fields)."` FROM $table";
        return $this;
    }

    public function getInsertQuery(array $fields, string $table): string
    {
        $filteredFields = array_filter($fields, fn($f) => $f !== 'id');
        if (empty($filteredFields)) {
            throw new \InvalidArgumentException("No valid fields to insert.");
        }
        $placeholders = array_fill(0, count($filteredFields), '%s');
    
        $columns = implode('`, `', $filteredFields);
        $placeholdersStr = implode(', ', $placeholders);
    
        return "INSERT INTO `{$table}` (`$columns`) VALUES ($placeholdersStr)";
    }

    public function getUpdateQuery(array $fields, string $table): string
    {
        $filteredFields = array_filter($fields, fn($f) => $f !== 'id');
        if (empty($filteredFields)) {
            throw new \InvalidArgumentException("No valid fields to update.");
        }
    
        $assignments = implode(', ', array_map(fn($f) => "`$f` = %s", $filteredFields));
    
        return "UPDATE `{$table}` SET $assignments WHERE `id` = %s";
    }

    public function distinct(string $field, string $table): self
    {
        $this->baseQuery = "SELECT DISTINCT $field FROM $table";
        return $this;
    }

    public function where(array $criteria): self
    {
        $this->strWhere = " WHERE 1=1";
        foreach ($criteria as $key => $value) {
            $this->strWhere .= " AND `$key` = %s";
            $this->params[] = $value;
        }
        return $this;
    }

    public function whereComplex(array $conditions): self
    {
        $this->strWhere = " WHERE 1=1";
        foreach ($conditions as $cond) {
            $this->strWhere .= " AND `{$cond['field']}` {$cond['operand']} %s";
            $this->params[] = $cond['value'];
        }
        return $this;
    }

    public function orderBy(array $orderBy): self
    {
        if (!empty($orderBy)) {
            $this->strOrderBy = " ORDER BY ";
            $orderParts = [];
            foreach ($orderBy as $field => $direction) {
                $orderParts[] = "$field $direction";
            }
            $this->strOrderBy .= implode(", ", $orderParts);
        }
        return $this;
    }

    public function limit(int $limit): self
    {
        if ($limit > 0) {
            $this->strLimit = " LIMIT $limit";
        }
        return $this;
    }

    public function getQuery(): string
    {
        return $this->baseQuery . $this->strWhere . $this->strOrderBy . $this->strLimit;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function reset(): self
    {
        $this->baseQuery = '';
        $this->strWhere = '';
        $this->strOrderBy = '';
        $this->strLimit = '';
        $this->params = [];
        return $this;
    }
}
