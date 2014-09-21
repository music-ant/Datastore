<?php

namespace MusicAnt\Datastore\Sql;


class SqlDataSource implements \MusicAnt\Datastore\DataSource {
    use SqlDataSourceTrait;

    private $connection;
    private $table;
    private $recordClass;

    public function __construct( \Pdo $connection, $table, $recordClass) {
        $this->connection = $connection;
        $this->table = $table;
        $this->recordClass = $recordClass;
    }


}
