<?php

/**
 * @package    contribute
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DomManipulator\Subscriber;


use Netzmacht\Contao\DomManipulator\Event\LoadHtmlEvent;
use Netzmacht\Contao\DomManipulator\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ReplaceInsertTagSubscriber solves issue with wrong encoding of insert tags.
 *
 * This issue occurs when they are used in html attributes. It just replaces them before.
 *
 * @package Netzmacht\Contao\DomManipulator\Subscriber
 */
class ReplaceInsertTagsSubscriber extends \Controller implements EventSubscriberInterface
{
    /**
     * Construct.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::LOAD_HTML => 'handleLoadHtmlEvent'
        );
    }

    /**
     * Replace insert tags.
     *
     * @param LoadHtmlEvent $event Load html event.
     *
     * @return void
     */
    public function handleLoadHtmlEvent(LoadHtmlEvent $event)
    {
        if (TL_MODE === 'FE') {
            $buffer = $this->replaceInsertTags($event->getHtml(), false);

            $event->setHtml($buffer);
        }
    }
}
