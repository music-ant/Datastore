<?hh

namespace MusicAnt\DataSource;

class SqlDataSource implements \MusicAnt\DataSource<T> {
    use SqlDataSourceTrait;

    public function __construct(
        private \Pdo $connection, private string
        $table, private string $recordClass
    ) {
        $this->getQuery = "SELECT * FROM $table WHERE id = :id;";
    }


}
