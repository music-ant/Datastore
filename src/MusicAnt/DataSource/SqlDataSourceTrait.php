<?php

namespace MusicAnt\DataSource;

use MusicAnt\Record;
use MusicAnt\SlowQueryException;

trait SqlDataSourceTrait {

    public function get($primaryKey) {
        $query = $this->connection->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id;"
        );
        $query->execute(array('id' => $primaryKey));

        return $query->fetchObject($this->recordClass);
    }

    public function find($searchFor, $acceptSlowQueries = false) {
        $searchFor = $searchFor ? $searchFor : array();
        $queryString = $this->createFindByQuery(array_keys($searchFor), $acceptSlowQueries) . ';';

        $query = $this->connection->prepare($queryString);
        $query->execute($searchFor);

        return $query->fetchObject($this->recordClass);
    }

    private function createFindByQuery($searchKeys, $acceptSlowQueries = false) {

        $queryString = "SELECT * FROM {$this->table} ";
        if (count($searchKeys) > 0) {
            $queryString .= 'WHERE ';
            $recordClass = $this->recordClass;
            $filterableColumns = $recordClass::getFilterableAttributes();

            $whereStmts = array_map(
                function($column) use($filterableColumns, $acceptSlowQueries) {
                    if (!$acceptSlowQueries && !in_array($column, $filterableColumns)) {
                        throw new SlowQueryException("column {$column} is not optimized for Searching");
                    }

                    return "`$column` = :$column";
                }, $searchKeys);

            $queryString .= join($whereStmts, ' AND ');
        }

        return $queryString;
    }

    public function findOrderedBy(
        array $searchFor, $orderAttribute, $ascending = true
    ) {
        if ($orderAttribute == null) {
            return $this->find($searchFor);
        }

        $recordClass = $this->recordClass;
        if (!in_array($orderAttribute, $recordClass::getOrderableAttributes())) {
            throw new SlowQueryException("column {$orderAttribute} is not optimized for Ordering");
        }

        $queryString = $this->createFindByQuery(array_keys($searchFor), false)
                . " ORDER BY `{$orderAttribute}` ASC;";

        $query = $this->connection->prepare($queryString);
        $query->execute($searchFor);

        return $query->fetchObject($this->recordClass);
    }

}
