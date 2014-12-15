<?php

/**
 * @package    contribute
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DomManipulator;

/**
 * Class Events contains all event names being provides by the dom manipulator.
 *
 * @package Netzmacht\Contao\DomManipulator
 */
class Events
{
    /**
     * Create dom manipualtor
     *
     * Dispatched event type is Netzmacht\Contao\DomManipulator\Event\CreateManipulatorEvent
     */
    const CREATE_MANIPULATOR = 'dom-manipulator.create';

    /**
     * Start event is emitted before the manipulation starts.
     *
     * Dispatched event type is Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent
     */
    const START_MANIPULATE = 'dom-manipulator.start';

    /**
     * Stop event is emitted after the manipulation finished.
     *
     * Dispatched event type is Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent
     */
    const STOP_MANIPULATE = 'dom-manipulator.stop';

    /**
     * Load Html event is emitted before content is loading into the dom.
     *
     * Dispatched event type is Netzmacht\Contao\DomManipulator\Event\LoadHtmlEvent
     */
    const LOAD_HTML = 'dom-manipulator.load-html';
}
