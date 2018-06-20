
Contao dom document manipulator
===============================

[![No Maintenance Intended](http://unmaintained.tech/badge.svg)](http://unmaintained.tech/)
[![Build Status](http://img.shields.io/travis/netzmacht/contao-dom-manipulator/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-dom-manipulator)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-dom-manipulator.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-dom-manipulator)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-dom-manipulator.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-dom-manipulator)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-dom-manipulator.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-dom-manipulator)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)


This extension integrates the PHP dom document manipulator into Contao.

Install
---------------------------

This library can be installed using composer

```
$ php composer.phar require netzmacht/contao-dom-manipulator:~1.0
$ php composer.phar updatet 
```

Usage
----------------------------

This extension hooks into the `parseFrontendTemplate` and `parseBackendTemplate` hook. It provides 4 events:

 * `Netzmacht\Contao\DomManipulator\Events::CREATE_MANIPULATOR`
   It's the event which collects the rules and creates the manipulator.
    
 * `Netzmacht\Contao\DomManipulator\Events::START_MANIPULATE`
   It's just a state notification event. It's called before the manipulation starts.
 
 * `Netzmacht\Contao\DomManipulator\Events::STOP_MANIPULATE`
   It's just a state notification event. It's called before the manipulation stops.
    
 * `Netzmacht\Contao\DomManipulator\Events::LOAD_HTML`
   It's called right before the html is load into the manipulator. Use it to fix hml if something is going wrong when 
   loading html into the dom.

To get more details how to create rules have a look at
[netzmacht/php-dom-manipulator](https://github.com/netzmacht/php-dom-manipulator).

Credits
----------------------------

This extension initially was extracted from the [toflar/contao-css-class-replacer](https://github.com/Toflar/contao-css-class-replacer)
which is maintained by Yanick Witschi alias [@Toflar](https://github.com/Toflar).
