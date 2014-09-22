<?php

namespace MusicAnt\Datastore\Sql;

use MusicAnt\Datastore\Record;

trait SqlDataDestinationTrait {

    public function create(Record $record) {
        if (!$this->tableExists()) {
            $this->tryToCreateTable($record);
        }

        
    }

    public function createMultiple(array $records) {

    }
}
