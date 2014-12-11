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

use Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent;
use Netzmacht\Contao\DomManipulator\Event\GetRulesEvent;
use Netzmacht\Contao\DomManipulator\Event\LoadHtmlEvent;
use Netzmacht\DomManipulator\DomManipulator;
use Netzmacht\DomManipulator\RuleInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
     * Dom manipulator.
     *
     * @var DomManipulator
     */
    private $manipulator;

    /**
     * Construct.
     *
     * @param EventSubscriberInterface $eventSubscriber Event subscriber.
     * @param DomManipulator           $manipulator     Dom manipulator.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function __construct(EventSubscriberInterface $eventSubscriber = null, DomManipulator $manipulator = null)
    {
        if (!$manipulator) {
            $config      = array('encoding' => \Config::get('characterSet'));
            $manipulator = DomManipulator::forNewDocument($config, array(), !\Config::get('debugMode'));;
        }

        $this->eventDispatcher = $eventSubscriber ?: $GLOBALS['container']['event-dispatcher'];
        $this->manipulator     = $manipulator;
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
        $rules = $this->getManipulationRules($templateName);
        if (empty($rules)) {
            return $buffer;
        }

        $event = new DomManipulationEvent($templateName);
        $this->eventDispatcher->dispatch(Events::START, $event);

        $event = new LoadHtmlEvent($templateName, $buffer);
        $this->eventDispatcher->dispatch(Events::LOAD_HTML, $event);

        $this->manipulator->loadHtml($event->getHtml());
        $buffer = $this->manipulator->manipulate();

        $event = new DomManipulationEvent($templateName);
        $this->eventDispatcher->dispatch(Events::STOP, $event);

        return $buffer;
    }

    /**
     * Get manipulation rules for a template.
     *
     * @param string $templateName Template name.
     *
     * @return RuleInterface[]
     */
    private function getManipulationRules($templateName)
    {
        $event = new GetRulesEvent($templateName);
        $this->eventDispatcher->dispatch(Events::LOAD_HTML, $event);

        $rules = $event->getRules();

        return $rules;
    }
}
