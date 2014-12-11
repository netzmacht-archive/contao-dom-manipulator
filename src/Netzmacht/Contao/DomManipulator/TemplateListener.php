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
 * Class Listener
 * @package Netzmacht\Contao\DomManipulator
 */
class Listener
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Manipulate the output.
     *
     * @param string $buffer       Generated output.
     * @param string $templateName Current template name.
     *
     * @return string
     * @throws \Exception
     */
    public function manipulate($buffer, $templateName)
    {
        $rules = $this->getManipulationRules($templateName);
        if (empty($rules)) {
            return $buffer;
        }

        $event = new DomManipulationEvent($templateName);
        $this->eventDispatcher->dispatch($event::START_EVENT, $event);

        $manipulator = $this->createManipulator($rules);
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

    /**
     * @param RuleInterface[] $rules
     *
     * @return DomManipulator
     */
    private function createManipulator($rules)
    {
        return DomManipulator::forNewDocument(
            array(
                'encoding' => \Config::get('characterSet')
            ),
            $rules,
            !\Config::get('debugMode')
        );
    }
}
