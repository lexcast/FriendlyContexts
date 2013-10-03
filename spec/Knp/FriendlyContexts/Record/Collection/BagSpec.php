<?php

namespace spec\Knp\FriendlyContexts\Record\Collection;

use PhpSpec\ObjectBehavior;

use Knp\FriendlyContexts\Reflection\ObjectReflector;
use Knp\FriendlyContexts\FacadeProvider;

class BagSpec extends ObjectBehavior
{

    /**
     * @param StdClass $rightObject
     * @param StdClass $wrongObject
     * @param Knp\FriendlyContexts\Reflection\ObjectReflector $reflector
     * @param Knp\FriendlyContexts\FacadeProvider $facade;
     **/
    function let(\StdClass $rightObject, \StdClass $wrongObject, ObjectReflector $reflector, FacadeProvider $facade)
    {
        $reflector->getClassName($rightObject)->willReturn('TheClass');
        $reflector->getClassNamespace($rightObject)->willReturn('The\\Name\\Space');
        $reflector->getClassLongName($rightObject)->willReturn('The\\Name\\Space\\TheClass');
        $reflector->isInstanceOf($rightObject, 'The\\Name\\Space\\TheClass')->willReturn(true);
        $reflector->isInstanceOf($rightObject, 'The\\Other\\Name\\Space\\TheOtherClass')->willReturn(false);

        $reflector->getClassName($wrongObject)->willReturn('TheOtherClass');
        $reflector->getClassNamespace($wrongObject)->willReturn('The\\Other\\Name\\Space');
        $reflector->getClassLongName($wrongObject)->willReturn('The\\Other\\Name\\Space\\TheOtherClass');
        $reflector->isInstanceOf($wrongObject, 'The\\Name\\Space\\TheClass')->willReturn(false);
        $reflector->isInstanceOf($wrongObject, 'The\\Other\\Name\\Space\\TheOtherClass')->willReturn(true);
        $facade->getDeps('object.reflector')->willReturn($reflector);

        $this->setFacadeProvider($facade);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\FriendlyContexts\Record\Collection\Bag');
    }

    function it_should_create_empty_collection(\StdClass $rightObject)
    {
        $this->get($rightObject)->shouldHaveType('Knp\FriendlyContexts\Record\Collection');
        $this->count()->shouldReturn(1);
    }

    function it_should_return_the_same_collection_for_the_same_object_type(\StdClass $rightObject)
    {
        $this->get($rightObject)->shouldHaveType('Knp\FriendlyContexts\Record\Collection');
        $this->get($rightObject)->shouldHaveType('Knp\FriendlyContexts\Record\Collection');
        $this->count()->shouldReturn(1);
    }

    function it_should_create_two_collections_for_tow_differents_object_types(\StdClass $rightObject, \StdClass $wrongObject)
    {
        $this->get($rightObject)->shouldHaveType('Knp\FriendlyContexts\Record\Collection');
        $this->get($wrongObject)->shouldHaveType('Knp\FriendlyContexts\Record\Collection');
        $this->count()->shouldReturn(2);
    }
}
