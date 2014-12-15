<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DomManipulator\Event;

use Netzmacht\DomManipulator\Factory;

/**
 * Class CreateManipulatorEvent is emitted when manipulator is created.
 *
 * @package Netzmacht\Contao\DomManipulator\Event
 */
class CreateManipulatorEvent extends DomManipulationEvent
{
    /**
     * Dom manipulator factory.
     *
     * @var Factory
     */
    private $factory;

    /**
     * Construct.
     *
     * @param Factory $factory      Dom manipulator factory.
     * @param string  $templateName Template name.
     */
    public function __construct(Factory $factory, $templateName)
    {
        parent::__construct($templateName);

        $this->factory = $factory;
    }

    /**
     * Get the factory.
     *
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
