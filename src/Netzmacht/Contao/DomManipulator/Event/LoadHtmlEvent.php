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

/**
 * Class LoadHtmlEvent is emitted before the html is loaded into the dom manipulator.
 *
 * Uses this event only if you run into some issue with the \DomDocument. For regular template parsing use the hook
 * instead!
 *
 * @package Netzmacht\Contao\DomManipulator\Event
 */
class LoadHtmlEvent extends DomManipulationEvent
{
    /**
     * Html being loaded;
     *
     * @var string
     */
    private $html;

    /**
     * Construct.
     *
     * @param string $templateName Template name.
     * @param string $html         Html buffer.
     */
    public function __construct($templateName, $html)
    {
        parent::__construct($templateName);

        $this->html = $html;
    }

    /**
     * Get the html content.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set the html content.
     *
     * @param string $html Html content.
     *
     * @return $this
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }
}
