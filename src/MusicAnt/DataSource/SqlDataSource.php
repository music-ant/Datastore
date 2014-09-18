<?php

namespace MusicAnt\DataSource;


class SqlDataSource implements \MusicAnt\DataSource {
    use SqlDataSourceTrait;

    private $connection;
    private $table;
    private $recordClass;

    public function __construct( \Pdo $connection, $table, $recordClass) {
        $this->connection = $connection;
        $this->table = $table;
        $this->recordClass = $recordClass;
        $this->getQuery = "SELECT * FROM $table WHERE id = :id;";
    }


}
