<?hh

namespace MusicAnt;

interface DataDestination {

    public function create(Record $record): bool;

    public function createMultiple(Set<Record> $records): bool;
}
