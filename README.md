
Contao dom document manipulator
===============================

[![Build Status](http://img.shields.io/travis/netzmacht/contao-dom-document/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-dom-document)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-dom-document.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-dom-document)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-dom-document.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-dom-document)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-dom-document.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-dom-document)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)


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

This extension initially was extracted from the [toflar/contao-css-class-replacer](https://github.com/Toflar/contao-css-class-replacer)
which is maintained by Yanick Witschi alias [@Toflar](https://github.com/Toflar).
