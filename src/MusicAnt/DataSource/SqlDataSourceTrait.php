<?php

namespace MusicAnt\DataSource;

use MusicAnt\Record;

trait SqlDataSourceTrait {

    public function get($primaryKey) {
        $query = $this->connection->prepare($this->getQuery);
        $query->execute(array('id' => $primaryKey));
        return $query->fetchObject($this->recordClass);
    }

    public function find(array $searchKeys) {
        return array();
    }

    public function findOrderedBy(
        array $searchKeys, array $orderAttributes
    ) {
        return array();
    }

}
