Bobel Helpers Library
=======================

[![Latest Stable Version](https://poser.pugx.org/phpunit/phpunit/version)](https://packagist.org/packages/phpunit/phpunit)
[![License](https://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit)

Library of helpful methods for PHP.

* DateTime Helper
* Enumerable Helper
* Link Helper
* Numeric Helper
* Text Helper
* Uri Helper

Just install the package and it is ready to use!


Requirements
============

* PHP >= 7.1

Installation
============

    composer require bobel/helpers

Usage
=====

```php
echo \Bobel\Helpers\Text::getRandomString($length = 16);

// Outputs Fb4tUW78cUuZZdPS


echo \Bobel\Helpers\Numeric::formatPrice(4000200.5);

// Outputs 4 000 200.50


\Bobel\Helecho pers\Link::setParam('param1', 'newValue', 'https://fake.url/?param1=value1&param2=value2')

// Outputs https://fake.url/?param1=newValue&param2=value2
```

Credits
=======

* Dmitrii Litovchenko https://www.linkedin.com/in/dmitrii-litovchenko
