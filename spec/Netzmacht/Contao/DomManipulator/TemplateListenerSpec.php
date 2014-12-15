<?php

namespace spec\Netzmacht\Contao\DomManipulator;

use Netzmacht\Contao\DomManipulator\Event\GetRulesEvent;
use Netzmacht\Contao\DomManipulator\Events;
use Netzmacht\Contao\DomManipulator\TemplateListener;
use Netzmacht\DomManipulator\DomManipulator;
use Netzmacht\DomManipulator\RuleInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TemplateListenerSpec
 * @package spec\Netzmacht\Contao\DomManipulator
 * @mixin TemplateListener
 */
class TemplateListenerSpec extends ObjectBehavior
{
    const BUFFER = '<html></html>';
    const TEMPLATE = 'fe_test';

    function let(EventDispatcherInterface $eventDispatcher, DomManipulator $manipulator)
    {
        $this->beConstructedWith($eventDispatcher, $manipulator);

        \Config::set('characterSet', 'utf-8');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\DomManipulator\TemplateListener');
    }

    function it_manipulates(EventDispatcherInterface $eventDispatcher, RuleInterface $rule)
    {
        $document = new \DOMDocument();
        $element  = $document->createElement('div');

        $rule->query(Argument::type('DOMDocument'))->willReturn(array($element));
        $rule->apply($element)->shouldBeCalled();

        $eventDispatcher->dispatch(Events::CREATE_MANIPULATOR, $this->eventArgument('CreateManipulator'))
            ->shouldBeCalled()
            ->will(function($args) use($rule) {
                    $args[1]->getFactory()->addRule($rule->getWrappedObject());
                }
            );

        $eventDispatcher->dispatch(Events::LOAD_HTML, $this->eventArgument('LoadHtml'))->shouldBeCalled();
        $eventDispatcher->dispatch(Events::START_MANIPULATE, $this->eventArgument('DomManipulation'))->shouldBeCalled();
        $eventDispatcher->dispatch(Events::STOP_MANIPULATE, $this->eventArgument('DomManipulation'))->shouldBeCalled();

        $this->manipulate(static::BUFFER, static::TEMPLATE);
    }

    function it_cancels_manipulation_if_no_rule_is_given(EventDispatcherInterface $eventDispatcher, RuleInterface $rule)
    {
        $eventDispatcher->dispatch(Events::CREATE_MANIPULATOR, $this->eventArgument('CreateManipulator'))->shouldBeCalled();
        $eventDispatcher->dispatch(Events::LOAD_HTML, $this->eventArgument('LoadHtml'))->shouldNotBeCalled();
        $eventDispatcher->dispatch(Events::START_MANIPULATE, $this->eventArgument('DomManipulation'))->shouldNotBeCalled();
        $eventDispatcher->dispatch(Events::STOP_MANIPULATE, $this->eventArgument('DomManipulation'))->shouldNotBeCalled();

        $this->manipulate(static::BUFFER, static::TEMPLATE);
    }

    private function eventArgument($class)
    {
        return Argument::type('Netzmacht\Contao\DomManipulator\Event\\' . $class . 'Event');
    }
}
