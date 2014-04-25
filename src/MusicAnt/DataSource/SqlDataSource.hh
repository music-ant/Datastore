<?hh

namespace MusicAnt\DataSource;

use string;

class SqlDataSource implements \MusicAnt\DataSource {
    use SqlDataSourceTrait;

    public function __construct(
        private \Pdo $connection, private string $table,
        private string $recordClass
    ) {
        $this->getQuery = "SELECT * FROM $table WHERE id = :id;";
    }


}
