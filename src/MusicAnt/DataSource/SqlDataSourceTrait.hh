<?hh

namespace MusicAnt\DataSource;

use MusicAnt\Record;

trait SqlDataSourceTrait {

    <<Override>> public function get($primaryKey): Record {
        $query = $this->connection->prepare($this->getQuery);
        $query->execute(array('id' => $primaryKey));
        return $query->fetchObject($this->recordClass);
    }

    public function find(Set<string> $searchKeys): Map<Record> {
        return new Map<Record>;
    }

    public function findOrderedBy(
        Set<string> $searchKeys, Vector<string> $orderAttributes
    ): Map<Record> {
        return new Map<Record>;
    }

}
