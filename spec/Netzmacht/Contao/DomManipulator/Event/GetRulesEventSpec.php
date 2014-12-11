<?php

namespace spec\Netzmacht\Contao\DomManipulator\Event;

use Netzmacht\Contao\DomManipulator\Event\GetRulesEvent;
use Netzmacht\DomManipulator\RuleInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class GetRulesEventSpec
 * @package spec\Netzmacht\Contao\DomManipulator\Event
 * @mixin GetRulesEvent
 */
class GetRulesEventSpec extends ObjectBehavior
{
    const TEMPLATE = 'template';

    function let()
    {
        $this->beConstructedWith(static::TEMPLATE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\DomManipulator\Event\GetRulesEvent');
    }

    function it_gets_template_name()
    {
        $this->getTemplateName()->shouldReturn(static::TEMPLATE);
    }

    function it_adds_a_rule(RuleInterface $rule)
    {
        $this->addRule($rule)->shouldReturn($this);
        $this->getRules()->shouldReturn(array($rule));
    }

    function it_adds_rule_by_priority(RuleInterface $rule, RuleInterface $ruleB, RuleInterface $ruleC)
    {
        $this->addRule($rule);
        $this->addRule($ruleB, -2);
        $this->addRule($ruleC, -1);

        $this->getRules()->shouldReturn(array($ruleB, $ruleC, $rule));
    }

    function it_adds_multiple_rules(RuleInterface $rule, RuleInterface $ruleB, RuleInterface $ruleC)
    {
        $this->addRules(array($rule, $ruleB, $ruleC))->shouldReturn($this);

        $this->getRules()->shouldReturn(array($rule, $ruleB, $ruleC));
    }
}
