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

use Netzmacht\Contao\DomManipulator\Event\CreateManipulatorEvent;
use Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent;
use Netzmacht\Contao\DomManipulator\Event\LoadHtmlEvent;
use Netzmacht\DomManipulator\Factory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TemplateListener hooks into Contao to run the dom manipulation.
 *
 * @package Netzmacht\Contao\DomManipulator
 */
class TemplateListener
{
    /**
     * Event dispatcher.
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Construct.
     *
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function __construct(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->eventDispatcher = $eventDispatcher ?: $GLOBALS['container']['event-dispatcher'];
    }

    /**
     * Manipulate the output.
     *
     * @param string $buffer       Generated output.
     * @param string $templateName Current template name.
     *
     * @return string
     *
     * @throws \Exception If something went wrong during dom manipulation and debug mode is enabled.
     */
    public function manipulate($buffer, $templateName)
    {
        $factory = new Factory();
        $factory->setSilentMode(\Config::get('debugMode'));

        $event = new CreateManipulatorEvent($factory, $templateName);
        $this->eventDispatcher->dispatch(Events::CREATE_MANIPULATOR, $event);

        if (!$factory->getRules()) {
            return $buffer;
        }

        // Notify that we start manipulation
        $event = new DomManipulationEvent($templateName);
        $this->eventDispatcher->dispatch(Events::START_MANIPULATE, $event);

        $manipulator = $factory->create();

        // Load html into dom
        $event = new LoadHtmlEvent($templateName, $buffer);
        $this->eventDispatcher->dispatch(Events::LOAD_HTML, $event);
        $manipulator->loadHtml($event->getHtml(), \Config::get('characterSet'));

        // Now manipulate the dom
        $buffer = $manipulator->manipulate();

        // Notify we have finished
        $event = new DomManipulationEvent($templateName);
        $this->eventDispatcher->dispatch(Events::STOP_MANIPULATE, $event);

        return $buffer;
    }
}
