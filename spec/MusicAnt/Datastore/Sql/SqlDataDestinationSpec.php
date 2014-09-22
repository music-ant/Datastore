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

    function it_is_initializable()
    {
        $this->shouldHaveType('MusicAnt\Datastore\Sql\SqlDataDestination');
    }
}

