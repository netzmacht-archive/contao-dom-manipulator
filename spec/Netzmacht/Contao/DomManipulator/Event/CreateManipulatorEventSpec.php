<?php

namespace spec\Netzmacht\Contao\DomManipulator\Event;

use Netzmacht\Contao\DomManipulator\Event\CreateManipulatorEvent;
use Netzmacht\DomManipulator\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class GetRulesEventSpec
 * @package spec\Netzmacht\Contao\DomManipulator\Event
 * @mixin CreateManipulatorEvent
 */
class CreateManipulatorEventSpec extends ObjectBehavior
{
    const TEMPLATE = 'template';

    function let(Factory $factory )
    {
        $this->beConstructedWith($factory, static::TEMPLATE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\DomManipulator\Event\CreateManipulatorEvent');
    }

    function it_gets_template_name()
    {
        $this->getTemplateName()->shouldReturn(static::TEMPLATE);
    }

    function it_gets_the_factory(Factory $factory)
    {
        $this->getFactory()->shouldReturn($factory);
    }
}
