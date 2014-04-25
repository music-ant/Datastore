<?hh

namespace MusicAnt;

use bool;

interface DataDestination {

    public function create(Record $record): bool;

    public function createMultiple(Set<Record> $records): bool;
}
