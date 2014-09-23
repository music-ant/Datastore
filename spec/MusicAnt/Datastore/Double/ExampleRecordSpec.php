<?php

namespace spec\MusicAnt\Datastore\Double;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleRecordSpec extends ObjectBehavior {
    use \MusicAnt\Datastore\SpecTrait\BaseRecordSpecTrait;

    function it_is_initializable()
    {
        $this->shouldHaveType('MusicAnt\Datastore\Double\ExampleRecord');
    }

    public function getExpectedMagicAttributes() {
        return array('foo', 'bar');
    }
}
