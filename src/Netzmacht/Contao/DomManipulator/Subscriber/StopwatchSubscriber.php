<?php

/**
 * @package    contribute
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DomManipulator\Subscriber;

use Netzmacht\Contao\DomManipulator\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Class StopWatchSubscriber integrates the debugging stopwatch for the dom manipulator.
 *
 * @package Netzmacht\Contao\DomManipulator\Subscriber
 */
class StopwatchSubscriber implements EventSubscriberInterface
{
    /**
     * Stop watch instance.
     *
     * @var Stopwatch
     */
    private $watch;

    /**
     * Construct.
     *
     * @param Stopwatch $stopwatch Stop watch.
     */
    public function __construct(Stopwatch $stopwatch)
    {
        $this->watch = $stopwatch;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::GET_RULES => 'start',
            Events::START     => 'lap',
            Events::STOP      => 'stop',
        );
    }

    /**
     * Start stopwatch.
     *
     * @return void
     */
    public function start()
    {
        $this->watch->start('dom_manipulator');
        $this->watch->start('dom_manipulator_rules');
    }

    /**
     * Lap when manipulation starts.
     *
     * @return void
     */
    public function lap()
    {
        $this->watch->stop('dom_manipulator_rules');
        $this->watch->start('dom_manipulator_manipulation');
    }

    /**
     * Stop and assign values to contao debug bar.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function stop()
    {
        $rulesEvent        = $this->watch->getEvent('dom_manipulator_rules');
        $manipulationEvent = $this->watch->stop('dom_manipulator_manipulation');
        $totalEvent        = $this->watch->stop('dom_manipulator');

        $GLOBALS['TL_DEBUG']['dom_manipulator_total'] = $this->formatDuration('total', $totalEvent);
        $GLOBALS['TL_DEBUG']['dom_manipulator_rules'] = $this->formatDuration('rule creation', $rulesEvent);
        $GLOBALS['TL_DEBUG']['dom_manipulator_dom']   = $this->formatDuration('manipulation', $manipulationEvent);
    }

    /**
     * Format duration.
     *
     * @param string         $name  Name of stop watch.
     * @param StopwatchEvent $event Stopwatch event.
     *
     * @return string
     */
    private function formatDuration($name, $event)
    {
        return 'Dom manipulation ' . $name . ' time: ' . $event->getDuration() . ' ms';
    }
}
