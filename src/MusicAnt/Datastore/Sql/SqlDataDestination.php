<?php

namespace MusicAnt\Datastore\Sql;

class SqlDataDestination implements \MusicAnt\Datastore\DataDestination{
    use SqlDataDestinationTrait;

    private $connection;
    private $table;
    private $recordClass;

    public function __construct( \Pdo $connection, $table, $recordClass) {
        $this->connection = $connection;
        $this->table = $table;
        $this->recordClass = $recordClass;
    }
}
