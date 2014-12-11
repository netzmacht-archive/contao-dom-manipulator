<?php

namespace spec\Netzmacht\Contao\DomManipulator\Event;

use Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class DomManipulationEventSpec
 * @package spec\Netzmacht\Contao\DomManipulator\Event
 * @mixin DomManipulationEvent
 */
class DomManipulationEventSpec extends ObjectBehavior
{
    const TEMPLATE = 'template';

    function let()
    {
        $this->beConstructedWith(static::TEMPLATE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent');
    }

    function it_gets_template_name()
    {
        $this->getTemplateName()->shouldReturn(static::TEMPLATE);
    }
}
