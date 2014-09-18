<?php

namespace MusicAnt;

use bool;

interface DataDestination {

    public function create(Record $record);

    public function createMultiple(array $records);
}
