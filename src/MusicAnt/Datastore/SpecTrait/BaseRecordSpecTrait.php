<?php

namespace MusicAnt\Datastore\SpecTrait;

use PhpSpec\Argument;

trait BaseRecordSpecTrait {

    function it_gets_magic_attributes_if_method_is_not_overwritten() {
        $expectedAttributes = $this->getAllExpectedAttributes();
        $this::getAttributes()->shouldReturn($expectedAttributes);
    }

    function it_is_possible_to_set_and_get_attributes_by_magic_methods() {
        foreach($this->getExpectedMagicAttributes() as $attribute) {
            $this->callSetterFor($attribute, $attribute);

            $result = $this->callGetterFor($attribute);

            $result->shouldBe($attribute);
        }
    }

    function it_should_return_itself_for_each_setter() {
        $specClazz = get_called_class();
        $clazz = substr($specClazz, 4, -4);

        foreach($this->getExpectedMagicAttributes() as $attribute) {
            $this->callSetterFor($attribute, $attribute)->shouldHaveType($clazz);
        }
    }

    private function callSetterFor($attribute, $value) {
        return call_user_func(
            array($this, 'set'.ucfirst($attribute)),
            $value
        );
    }

    private function callGetterFor($attribute) {
        return call_user_func(
            array($this, 'get'.ucfirst($attribute)), null
        );
    }

    private function getAllExpectedAttributes() {
        $expectedAttributes = array();
        $expectedAttributes[] = 'id';
        foreach($this->getExpectedMagicAttributes() as $childAttributes) {
            $expectedAttributes[] = $childAttributes;
        }

        return $expectedAttributes;
    }

}
