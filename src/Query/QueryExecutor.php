<?php
namespace src\Query;

use src\Collection\Collection;
use src\Entity\Entity;

class QueryExecutor
{

    public function fetchOne(string $sql, string $entityClass, array $params = []): ?Entity
    {
        global $wpdb;
        $prepared = $wpdb->prepare($sql, $params);
        $result = $wpdb->get_row($prepared, 'ARRAY_A');
        return $result ? new $entityClass(...$result) : null;
    }

    public function fetchAll(string $sql, string $entityClass, array $params = []): Collection
    {
        global $wpdb;
        $prepared = $wpdb->prepare($sql, $params);
        $results = $wpdb->get_results($prepared, 'ARRAY_A');

        $collection = new Collection();
        while (!empty($results)) {
            $result = array_shift($results);
            $entity = new $entityClass(...$result);
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
