<?php
namespace src\Query;

use src\Collection\Collection;
use src\Entity\Entity;

class QueryExecutor
{

    public function fetchOne(string $sql, string $entityClass, array $params = [], bool $display=false): ?Entity
    {
        $collection = $this->fetchAll($sql, $entityClass, $params, $display);
        return $collection->first() ?: null;
    }

    public function fetchAll(string $sql, string $entityClass, array $params = [], bool $display=false): Collection
    {
        global $wpdb;
        $prepared = $wpdb->prepare($sql, $params);
        if ($display) {
            echo '[['.$prepared.']]';
        }

        $results = $wpdb->get_results($prepared, 'ARRAY_A');
        $collection = new Collection();
        foreach ($results as $result) {
            $entity = method_exists($entityClass, 'factory')
                ? $entityClass::factory($result)
                : new $entityClass($result);
            $collection->addItem($entity);
        }

        return $collection;
    }

    public function insert(string $sql, array $params = []): int
    {
        global $wpdb;
        $prepared = $wpdb->prepare($sql, $params);
        $wpdb->query($prepared);
        return (int) $wpdb->insert_id;
    }
    
    public function update(string $sql, array $params = []): int
    {
        global $wpdb;
        $prepared = $wpdb->prepare($sql, $params);
        $wpdb->query($prepared);
        return (int) $wpdb->rows_affected;
    }
}
