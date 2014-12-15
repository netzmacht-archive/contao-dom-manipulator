<?php

namespace spec\Netzmacht\Contao\DomManipulator\Subscriber;

use Netzmacht\Contao\DomManipulator\Events;
use Netzmacht\Contao\DomManipulator\Subscriber\StopwatchSubscriber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Class StopwatchSubscriberSpec
 * @package spec\Netzmacht\Contao\DomManipulator\Subscriber
 * @mixin StopwatchSubscriber
 */
class StopwatchSubscriberSpec extends ObjectBehavior
{
    function let(Stopwatch $stopwatch)
    {
        $this->beConstructedWith($stopwatch);

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\DomManipulator\Subscriber\StopwatchSubscriber');
    }

    function it_is_a_event_subscriber()
    {
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_listens_to_events()
    {
        $this->getSubscribedEvents()->shouldSubscribe(Events::START_MANIPULATE);
        $this->getSubscribedEvents()->shouldSubscribe(Events::STOP_MANIPULATE);
        $this->getSubscribedEvents()->shouldSubscribe(Events::CREATE_MANIPULATOR);
    }

    function it_starts(Stopwatch $stopwatch)
    {
        $stopwatch->start('dom_manipulator')->shouldBeCalled();
        $stopwatch->start('dom_manipulator_rules')->shouldBeCalled();

        $this->start();
    }

    function it_laps(Stopwatch $stopwatch)
    {
        $stopwatch->stop('dom_manipulator_rules')->shouldBeCalled();
        $stopwatch->start('dom_manipulator_manipulation')->shouldBeCalled();

        $this->lap();
    }

    function it_stops(Stopwatch $stopwatch, StopwatchEvent $event)
    {
        $stopwatch->getEvent('dom_manipulator_rules')->shouldBeCalled()->willReturn($event);
        $stopwatch->stop('dom_manipulator')->shouldBeCalled()->willReturn($event);
        $stopwatch->stop('dom_manipulator_manipulation')->shouldBeCalled()->willReturn($event);

        $this->stop();
    }

    public function getMatchers()
    {
        return array(
            'subscribe' => function($subject, $key) {
                return array_key_exists($key, $subject);
            }
        );
    }
}
