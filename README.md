PHP Pattern
===========

[![Build Status](https://travis-ci.org/QoboLtd/PHP-Pattern.svg?branch=master)](https://travis-ci.org/QoboLtd/PHP-Pattern)
[![Latest Stable Version](https://poser.pugx.org/qobo/pattern/v/stable)](https://packagist.org/packages/qobo/pattern) 
[![Total Downloads](https://poser.pugx.org/qobo/pattern/downloads)](https://packagist.org/packages/qobo/pattern) 
[![Latest Unstable Version](https://poser.pugx.org/qobo/pattern/v/unstable)](https://packagist.org/packages/qobo/pattern) 
[![License](https://poser.pugx.org/qobo/pattern/license)](https://packagist.org/packages/qobo/pattern)

PHP library to manipulate text patterns with placeholders.

Install
-------

Add a dependency on ```qobo/pattern``` to your project's ```composer.json``` like so:

```json
{
	"require": {
		"qobo/pattern": "~1.0"
	}
}
```

or simply install from the command line like so:

```$ composer require qobo/pattern:1.0.*```

Usage
-----

Here is the simplest example of usage:

```php
<?php
require_once 'vendor/autoload.php';

$pattern = new \Qobo\Pattern\Pattern('Hello %%NAME%%');
print $pattern->parse(array('NAME' => 'Leonid'));
// result: Hello Leonid
?>
```

Here is an example with recursive parsing (the order of arguments doesn't matter):

```php
<?php
require_once 'vendor/autoload.php';

$pattern = new \Qobo\Pattern\Pattern('Hello %%NAME%%');
print $pattern->parse(array('TITLE' => 'Mr.', 'NAME' => '%%TITLE%% Leonid'));
// result: Hello Mr. Leonid
?>
```

For more examples, see the unit tests.
