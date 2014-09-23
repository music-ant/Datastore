<?php

namespace MusicAnt\Datastore\Sql;

use MusicAnt\Datastore\Record;

trait SqlDataDestinationTrait {

    public function create(Record $record) {
        $attributeList = $record->getAttributes();

        $valueStmt = array_map(function($attribute) {
            return ":$attribute";
        }, $attributeList);

        $statement = $this->connection->prepare(
            'INSERT INTO Testable VALUES ('. join($valueStmt, ', ') .');'
        );

        $statement->execute($this->extractAttributesWithValues($record));
    }

    public function createMultiple(array $records) {

    }

    private function extractAttributesWithValues(Record $record) {
        $attributes = array();
        foreach ($record->getAttributes() as $attribute) {
            $getter = "get".ucfirst($attribute);
            $value = call_user_func(array($record, $getter), null);
            $attributes[$attribute] = $value;
        }
        return $attributes;
    }
}
