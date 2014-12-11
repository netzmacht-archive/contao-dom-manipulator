
Contao dom document manipulator
===============================

This extension integrates the PHP dom document manipulator into Contao.

Install
---------------------------

This library can be installed using composer

```
$ php composer.phar require netzmacht/contao-dom-manipulator:~1.0
$ php composer.phar update
```

Usage
----------------------------

This extension hooks into the `parseFrontendTemplate` and `parseBackendTemplate` hook. It provides 3 events:

 * `Netzmacht\Contao\DomManipulator\Event\GetRulesEvent::NAME`
   If the main event you need. Here you can create your rules for the manipulator.
    
 * `Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent::START_EVENT`
   It's just a state notification event. It's called before the manipulation starts.
 
 * `Netzmacht\Contao\DomManipulator\Event\DomManipulationEvent::STOP_EVENT`
   It's just a state notification event. It's called before the manipulation stops.

To get more details how to create rules have a look at
[netzmacht/php-dom-manipulator](https://github.com/netzmacht/php-dom-manipulator).

Credits
----------------------------

This extension initial was extracted from the [toflar/contao-css-class-replacer](https://github.com/Toflar/contao-css-class-replacer)
which is maintained by Yanick Witschi alias [@Toflar](https://github.com/Toflar).
