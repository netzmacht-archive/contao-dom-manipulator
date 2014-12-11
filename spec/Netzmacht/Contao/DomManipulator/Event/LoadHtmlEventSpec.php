<?php

namespace spec\Netzmacht\Contao\DomManipulator\Event;

use Netzmacht\Contao\DomManipulator\Event\LoadHtmlEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class LoadHtmlEventSpec
 * @package spec\Netzmacht\Contao\DomManipulator\Event
 * @mixin LoadHtmlEvent
 */
class LoadHtmlEventSpec extends ObjectBehavior
{
    const TEMPLATE = 'template';

    const HTML = 'html';

    function let()
    {
        $this->beConstructedWith(static::TEMPLATE, static::HTML);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\DomManipulator\Event\LoadHtmlEvent');
    }

    function it_gets_template_name()
    {
        $this->getTemplateName()->shouldReturn(static::TEMPLATE);
    }

    function it_gets_html()
    {
        $this->getHtml()->shouldReturn(static::HTML);
    }

    function it_sets_html()
    {
        $this->setHtml('new')->shouldReturn($this);
        $this->getHtml()->shouldReturn('new');
    }
}
