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

use Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent;
use Netzmacht\Contao\DomManipulator\Event\GetRulesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopEvent;

/**
 * Class StopWatchSubscriber
 *
 * @package Netzmacht\Contao\DomManipulator\Subscriber
 */
class StopWatchSubscriber implements EventSubscriberInterface
{
    /**
     * Stop watch instance.
     *
     * @var Stopwatch
     */
    private $watch;

    /**
     * Construct.
     */
    function __construct()
    {
        $this->watch = new Stopwatch();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            GetRulesEvent::NAME               => 'start',
            DomManipulationEvent::START_EVENT => 'lap',
            DomManipulationEvent::STOP_EVENT  => 'stop',
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
     * @param string    $name      Name of stop watch.
     * @param StopEvent $stopEvent StopEvent.
     *
     * @return string
     */
    private function formatDuration($name, $stopEvent)
    {
        return 'Dom manipulation ' . $name . ' time: ' . $stopEvent->getDuration() . ' ms';
    }
}
