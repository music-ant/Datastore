<?php

namespace MusicAnt;

use string;

interface DataSource {

    public function get($primaryKey);

    public function find($searchKeys);

    public function findOrderedBy(
        array $searchKeys, array $orderAttributes
    );
}
