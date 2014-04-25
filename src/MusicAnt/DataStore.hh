<?hh

namespace MusicAnt;

interface DataStore<T as Record> extends DataSource<T>, DataDestination<T> {

}
