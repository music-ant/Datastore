<?php

namespace spec\MusicAnt\Datastore\Sql;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use MusicAnt\Datastore\Double\StringTestRecord;

class SqlDataSourceSpec extends ObjectBehavior
{

    function let(\Pdo $connection)
    {
        StringTestRecord::setFilterableAttributes(array('name'));
        $this->beConstructedWith($connection, 'Testtable',
                '\MusicAnt\Datastore\Double\StringTestRecord');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MusicAnt\Datastore\Sql\SqlDataSource');
    }

    function it_gets_a_single_record(\Pdo $connection, \PDOStatement $sqlResult)
    {
        $primaryKey = 1;
        $expectedObject = new StringTestRecord($primaryKey, 'test');
        $connection->prepare("SELECT * FROM Testtable WHERE id = :id;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array('id' => $primaryKey))->shouldBeCalled();
        $sqlResult->fetchObject("\MusicAnt\Datastore\Double\StringTestRecord")->willReturn($expectedObject);

        $this->get($primaryKey)->shouldReturn($expectedObject);
    }

    function it_will_throw_a_SlowQueryException_when_search_for_a_nonfilterable_attribute(\Pdo $connection, \PDOStatement $sqlResult) {
        StringTestRecord::setFilterableAttributes(array());

        $connection->prepare(Argument::any())
                   ->willReturn($sqlResult);

        $this->shouldThrow("\MusicAnt\Datastore\SlowQueryException")->duringFind(array('name'=>'foo'));
    }

    function it_will_not_throw_an_Exception_when_search_for_a_nonfilterable_attribute_and_accept_slow_queries(\Pdo $connection, \PDOStatement $sqlResult) {
        StringTestRecord::setFilterableAttributes(array());

        $connection->prepare(Argument::any())
                   ->willReturn($sqlResult);

        $this->shouldNotThrow("\Exception")->duringFind(array('name'=>'foo'), true);
    }

    function it_finds_all_records_with_no_searchCondition(\Pdo $connection, \PDOStatement $sqlResult) {
        $expectedObjects = array(true, false);

        $connection->prepare("SELECT * FROM Testtable ;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array())->shouldBeCalled();

        $sqlResult->fetchObject("\MusicAnt\Datastore\Double\StringTestRecord")->willReturn($expectedObjects);

        $this->find(null)->shouldReturn($expectedObjects);
    }

    function it_finds_all_records_with_empty_array_as_searchCondition(\Pdo $connection, \PDOStatement $sqlResult) {
        $expectedObjects = array(true, false);

        $connection->prepare("SELECT * FROM Testtable ;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array())->shouldBeCalled();

        $sqlResult->fetchObject("\MusicAnt\Datastore\Double\StringTestRecord")->willReturn($expectedObjects);

        $this->find(array())->shouldReturn($expectedObjects);
    }

    function it_finds_multiple_records_by_name(\Pdo $connection, \PDOStatement $sqlResult)
    {
        $searchForName = "oso";
        $expectedObject = array(
            new StringTestRecord(1, $searchForName),
            new StringTestRecord(1, $searchForName)
        );

        $connection->prepare("SELECT * FROM Testtable WHERE `name` = :name;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array('name' => $searchForName))->shouldBeCalled();
        $sqlResult->fetchObject("\MusicAnt\Datastore\Double\StringTestRecord")->willReturn($expectedObject);

        $this->find(array('name' => $searchForName))->shouldReturn($expectedObject);
    }

    function it_throws_exception_trying_to_sort_by_column_which_is_not_indexed(\Pdo $connection, \PDOStatement $sqlResult) {
        StringTestRecord::setOrderableAttributes(array('id'));

        $connection->prepare(Argument::any())
                   ->willReturn($sqlResult);

        $this->shouldThrow("\MusicAnt\Datastore\SlowQueryException")->duringFindOrderedBy(array('name'=>'foo'), 'name');
    }

    function it_findOrdered_is_the_same_like_find_with_null_as_OrderAttribute(\Pdo $connection, \PDOStatement $sqlResult) {
        $searchForName = "oso";
        $expectedObject = array(
            new StringTestRecord(1, $searchForName),
            new StringTestRecord(1, $searchForName)
        );

        $connection->prepare("SELECT * FROM Testtable WHERE `name` = :name;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array('name' => $searchForName))->shouldBeCalled();
        $sqlResult->fetchObject("\MusicAnt\Datastore\Double\StringTestRecord")->willReturn($expectedObject);

        $this->findOrderedBy(array('name' => $searchForName), null)->shouldReturn($expectedObject);
    }


    function it_finds_mutliple_records_by_name_sorted_by_name(\Pdo $connection, \PDOStatement $sqlResult) {
        StringTestRecord::setOrderableAttributes(array('name'));

        $searchForName = "oso";
        $expectedObject = array(
            new StringTestRecord(1, $searchForName),
            new StringTestRecord(1, $searchForName)
        );

        $connection->prepare("SELECT * FROM Testtable WHERE `name` = :name ORDER BY `name` ASC;")
                   ->willReturn($sqlResult);

        $sqlResult->execute(array('name' => $searchForName))->shouldBeCalled();
        $sqlResult->fetchObject("\MusicAnt\Datastore\Double\StringTestRecord")->willReturn($expectedObject);

        $this->findOrderedBy(array('name' => $searchForName), 'name')->shouldReturn($expectedObject);
    }
}
