<?php

use Netzmacht\Contao\DomManipulator\Subscriber\StopwatchSubscriber;
use Symfony\Component\Stopwatch\Stopwatch;

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array(
    'Netzmacht\Contao\DomManipulator\TemplateListener',
    'manipulate'
);

$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array(
    'Netzmacht\Contao\DomManipulator\TemplateListener',
    'manipulate'
);

$GLOBALS['TL_HOOKS']['initializeDependencyContainer'][] = function(\Pimple $container) {
    // Add stop watch subscriber if we are in debug mode.
    if (\Config::get('debugMode')) {
        $container['event-dispatcher']
            ->addSubscriber(new StopwatchSubscriber(new Stopwatch()));
    }
};
