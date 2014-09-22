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

    function it_is_possible_to_pass_Attributes_to_constructor_as_Parameters() {
        $this->beConstructedWith(1, 'foo', 'bar');
    }


    public function getExpectedMagicAttributes() {
        return array('foo', 'bar');
    }
}
