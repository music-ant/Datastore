<?php

namespace MusicAnt;

use string;

interface DataSource {

    public function get($primaryKey);

    public function find($searchFor, $acceptSlowQueries = false);

    public function findOrderedBy(
        array $searchKeys, $orderAttribute, $ascending = true
    );
}
