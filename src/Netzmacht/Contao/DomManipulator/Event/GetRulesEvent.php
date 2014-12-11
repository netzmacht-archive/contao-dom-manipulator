<?php

/**
 * @package    contribute
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DomManipulator\Event;

use Netzmacht\DomManipulator\RuleInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class GetRulesEvent is emitted when the template listener collects are rules which should be applied.
 *
 * @package Netzmacht\Contao\DomManipulator\Event
 */
class GetRulesEvent extends Event
{
    /**
     * Collection of rules.
     *
     * @var array
     */
    private $rules = array();

    /**
     * Name of the template.
     *
     * @var string
     */
    private $templateName;

    /**
     * Construct.
     *
     * @param string $templateName Name of template being parsed.
     */
    public function __construct($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * Get template name.
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * Add a rule to the event.
     *
     * @param RuleInterface $rule     Rule being added.
     * @param int           $priority Define a priority.
     *
     * @return $this
     */
    public function addRule(RuleInterface $rule, $priority = 0)
    {
        $this->rules[$priority][] = $rule;

        return $this;
    }

    /**
     * Add multiple rules.
     *
     * @param array|RuleInterface[] $rules    List of rules.
     * @param int                   $priority Priority is used for each rule.
     *
     * @return $this
     */
    public function addRules(array $rules, $priority = 0)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule, $priority);
        }

        return $this;
    }

    /**
     * Get rules prioritized.
     *
     * @return RuleInterface[]
     */
    public function getRules()
    {
        $rules = array();

        ksort($this->rules);

        foreach ($this->rules as $prioritized) {
            $rules = array_merge($rules, $prioritized);
        }

        return $rules;
    }
}
