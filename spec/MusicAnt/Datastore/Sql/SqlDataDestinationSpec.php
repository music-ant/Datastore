<?php

namespace spec\MusicAnt\Datastore\Sql;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use MusicAnt\Datastore\Double\StringTestRecord;

class SqlDataDestinationSpec extends ObjectBehavior
{

    function let(\Pdo $connection) {
        $this->beConstructedWith($connection, 'Testtable',
                '\spec\MusicAnt\Datastore\Sql\StringRecord');
    }

    function it_is_initializable() {
        $this->shouldHaveType('MusicAnt\Datastore\Sql\SqlDataDestination');
    }

    function it_creates_a_record(\Pdo $connection, \PDOStatement $sqlResult) {
        $testRecord = new StringTestRecord(1, 'foo');

        $connection->prepare("INSERT INTO Testable VALUES (:id, :name);")
                ->willReturn($sqlResult);
        $sqlResult->execute(array('id' => 1, 'name' => 'foo'))->shouldBeCalled();

        $this->create($testRecord);
    }
}

