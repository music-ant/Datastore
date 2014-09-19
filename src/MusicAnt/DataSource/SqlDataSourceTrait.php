<?php

namespace MusicAnt\DataSource;

use MusicAnt\Record;

trait SqlDataSourceTrait {

    public function get($primaryKey) {
        $query = $this->connection->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id;"
        );
        $query->execute(array('id' => $primaryKey));

        return $query->fetchObject($this->recordClass);
    }

    public function find($searchKeys, $acceptSlowQueries = false) {
        $searchKeys = $searchKeys ? $searchKeys : array();

        $queryString = "SELECT * FROM {$this->table} ";
        if (count($searchKeys) > 0) {
            $queryString .= 'WHERE ';
            $recordClass = $this->recordClass;
            $filterableColumns = $recordClass::getFilterableAttributes();

            $whereStmts = array_map(
                function($column) use($filterableColumns, $acceptSlowQueries) {
                    if (!$acceptSlowQueries && !in_array($column, $filterableColumns)) {
                        throw new \Exception("column {$column} is not optimized for Searching");
                    }

                    return "`$column` = :$column";
                }, array_keys($searchKeys));

            $queryString .= join($whereStmts, ' AND ');
        }
        $queryString .= ';';

        $query = $this->connection->prepare($queryString);
        $query->execute($searchKeys);

        return $query->fetchObject($this->recordClass);
    }

    public function findOrderedBy(
        array $searchKeys, array $orderAttributes
    ) {
        return array();
    }

}
