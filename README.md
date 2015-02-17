PHP Pattern
===========

[![Build Status](https://travis-ci.org/QoboLtd/PHP-Pattern.svg?branch=master)](https://travis-ci.org/QoboLtd/PHP-Pattern)

PHP library to manipulate text patterns with placeholders.

Install
-------

Add a dependency on ```qobo/pattern``` to your project's ```composer.json``` like so:

```
{
	"require": {
		"qobo/pattern": "1.0.*"
	}
}
```

Usage
-----

Here is the simplest example of usage:

```
<?php
use \Qobo\Pattern\Pattern;

$pattern = new Pattern('Hello %%NAME%%');
print $pattern->parse(array('NAME' => 'Leonid'));
// result: Hello Leonid
?>
```

For more examples, check the unit tests.
