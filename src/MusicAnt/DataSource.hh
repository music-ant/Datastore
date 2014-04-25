<?hh

namespace MusicAnt;

use string;

interface DataSource {

    public function get($primaryKey): Record;

    public function find(Set<string> $searchKeys): Map<Record>;

    public function findOrderedBy(
        Set<string> $searchKeys, Vector<string> $orderAttributes
    ): Map<Record>;
}
