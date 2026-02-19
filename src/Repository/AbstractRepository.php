<?php
namespace src\Repository;

abstract class AbstractRepository
{
    protected function getWpdb(): \wpdb
    {
        global $wpdb;
        return $wpdb;
    }

    public function beginTransaction(): void
    {
        $this->getWpdb()->query('START TRANSACTION');
    }

    public function commit(): void
    {
        $this->getWpdb()->query('COMMIT');
    }

    public function rollBack(): void
    {
        $this->getWpdb()->query('ROLLBACK');
    }
}
