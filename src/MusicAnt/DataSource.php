<?php

namespace MusicAnt;

use string;

interface DataSource {

    public function get($primaryKey);

    public function find($searchKeys, $acceptSlowQueries = false);

    public function findOrderedBy(
        array $searchKeys, array $orderAttributes
    );
}
