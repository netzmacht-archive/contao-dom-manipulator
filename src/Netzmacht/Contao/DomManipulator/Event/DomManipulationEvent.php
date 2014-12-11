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

use Symfony\Component\EventDispatcher\Event;

/**
 * Class DomManipulationEvent is a state event which just notifies that something happens.
 *
 * @package Netzmacht\Contao\DomManipulator\Event
 */
class DomManipulationEvent extends Event
{
    /**
     * Template name.
     *
     * @var string
     */
    private $templateName;

    /**
     * Construct.
     *
     * @param string $templateName Template name.
     */
    public function __construct($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * Get the template name.
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }
}
