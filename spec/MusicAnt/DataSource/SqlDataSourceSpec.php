<?hh

namespace spec\MusicAnt\DataSource;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SqlDataSourceSpec extends ObjectBehavior
{

    function let(\Pdo $connection)
    {
        $this->beConstructedWith($connection, 'Testtable',
                '\MusicAnt\StringRecord');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MusicAnt\DataSource\SqlDataSource');
    }

    function it_gets_a_single_record(\Pdo $connection, \PDOStatement $sqlResult)
    {
        $primaryKey = 1;
        $expectedObject = new StringRecord($primaryKey, 'test');
        $connection->prepare("SELECT * FROM Testtable WHERE id = :id;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array('id' => $primaryKey))->shouldBeCalled();
        $sqlResult->fetchObject("\MusicAnt\StringRecord")->willReturn($expectedObject);

        $this->get($primaryKey)->shouldReturn($expectedObject);
    }
}

class StringRecord implements \MusicAnt\Record{

    public function __construct(public int $id, public string $name) {

    }

    public function getId() {
        return $this->id;
    }

    public function getFilterableAttributes() {
        return new Set<string>();
    }

    public function getOrderableAttributes() {
        return new Set<string>();
    }

}
