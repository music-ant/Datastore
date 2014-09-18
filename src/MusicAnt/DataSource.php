<?php

namespace MusicAnt;

use string;

interface DataSource {

    public function get($primaryKey);

    public function find(array $searchKeys);

    public function findOrderedBy(
        array $searchKeys, array $orderAttributes
    );
}
