<?php

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
    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getFilterableAttributes() {
        return array();
    }

    public function getOrderableAttributes() {
        return array();
    }

}
