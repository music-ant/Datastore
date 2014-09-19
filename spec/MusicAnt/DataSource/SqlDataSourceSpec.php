<?php

namespace spec\MusicAnt\DataSource;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SqlDataSourceSpec extends ObjectBehavior
{

    function let(\Pdo $connection)
    {
        StringRecord::setFilterableAttributes(array('name'));
        $this->beConstructedWith($connection, 'Testtable',
                '\spec\MusicAnt\DataSource\StringRecord');
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
        $sqlResult->fetchObject("\spec\MusicAnt\DataSource\StringRecord")->willReturn($expectedObject);

        $this->get($primaryKey)->shouldReturn($expectedObject);
    }

    function it_will_throw_an_Exception_when_search_for_a_nonfilterable_attribute(\Pdo $connection, \PDOStatement $sqlResult) {
        StringRecord::setFilterableAttributes(array());

        $connection->prepare(Argument::any())
                   ->willReturn($sqlResult);

        $this->shouldThrow("\Exception")->duringFind(array('name'=>'foo'));
    }

    function it_will_not_throw_an_Exception_when_search_for_a_nonfilterable_attribute_and_accept_slow_queries(\Pdo $connection, \PDOStatement $sqlResult) {
        StringRecord::setFilterableAttributes(array());

        $connection->prepare(Argument::any())
                   ->willReturn($sqlResult);

        $this->shouldNotThrow("\Exception")->duringFind(array('name'=>'foo'), true);
    }

    function it_finds_all_records_with_no_searchCondition(\Pdo $connection, \PDOStatement $sqlResult) {
        $expectedObjects = array(true, false);

        $connection->prepare("SELECT * FROM Testtable ;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array())->shouldBeCalled();

        $sqlResult->fetchObject("\spec\MusicAnt\DataSource\StringRecord")->willReturn($expectedObjects);

        $this->find(null)->shouldReturn($expectedObjects);
    }

    function it_finds_all_records_with_empty_array_as_searchCondition(\Pdo $connection, \PDOStatement $sqlResult) {
        $expectedObjects = array(true, false);

        $connection->prepare("SELECT * FROM Testtable ;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array())->shouldBeCalled();

        $sqlResult->fetchObject("\spec\MusicAnt\DataSource\StringRecord")->willReturn($expectedObjects);

        $this->find(array())->shouldReturn($expectedObjects);
    }

    function it_finds_multiple_records_by_name(\Pdo $connection, \PDOStatement $sqlResult)
    {
        $searchForName = "oso";
        $expectedObject = array(
            new StringRecord(1, $searchForName),
            new StringRecord(1, $searchForName)
        );

        $connection->prepare("SELECT * FROM Testtable WHERE `name` = :name;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array('name' => $searchForName))->shouldBeCalled();
        $sqlResult->fetchObject("\spec\MusicAnt\DataSource\StringRecord")->willReturn($expectedObject);

        $this->find(array('name' => $searchForName))->shouldReturn($expectedObject);
    }
}

class StringRecord implements \MusicAnt\Record{
    public $id;
    public $name;
    public static  $filterableAttributes;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public static function setFilterableAttributes($attributes) {
        self::$filterableAttributes = $attributes;
    }
    public static function getFilterableAttributes() {
        return self::$filterableAttributes;
    }

    public static function getOrderableAttributes() {
        return array();
    }

}
