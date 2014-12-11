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
use Netzmacht\DomManipulator\DomManipulator;
use Netzmacht\DomManipulator\RuleInterface;
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
     * It's a Contao integration - so no dependency injection here.
     *
     * @SuppressWarnings(PHPMD.Superglobals);
     */
    public function __construct()
    {
        $this->eventDispatcher = $GLOBALS['container']['event-dispatcher'];
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
        $this->eventDispatcher->dispatch($event::START_EVENT, $event);

        $config      = array('encoding' => \Config::get('characterSet'));
        $manipulator = DomManipulator::forNewDocument($config, $rules, !\Config::get('debugMode'));
        $buffer      = $manipulator->manipulate();

        $event = new DomManipulationEvent($templateName);
        $this->eventDispatcher->dispatch($event::START_EVENT, $event);

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
        $this->eventDispatcher->dispatch($event::NAME, $event);

        $rules = $event->getRules();

        return $rules;
    }
}
