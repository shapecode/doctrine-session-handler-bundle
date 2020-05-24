# Shapecode - Doctrine Session Handler Bundle

[![paypal](https://img.shields.io/badge/Donate-Paypal-blue.svg)](http://paypal.me/nloges)

[![PHP Version](https://img.shields.io/packagist/php-v/shapecode/doctrine-session-handler-bundle.svg)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Latest Stable Version](https://img.shields.io/packagist/v/shapecode/doctrine-session-handler-bundle.svg?label=stable)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/shapecode/doctrine-session-handler-bundle.svg?label=unstable)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/shapecode/doctrine-session-handler-bundle.svg)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Monthly Downloads](https://img.shields.io/packagist/dm/shapecode/doctrine-session-handler-bundle.svg)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Daily Downloads](https://img.shields.io/packagist/dd/shapecode/doctrine-session-handler-bundle.svg)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![License](https://img.shields.io/packagist/l/shapecode/doctrine-session-handler-bundle.svg)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)

This bundle provides a Doctrine session handler to save sessions in a database.

## Install instructions

Installing this bundle can be done through these simple steps:

Add the bundle to your project as a composer dependency:

```bash
$ composer require shapecode/doctrine-session-handler-bundle
```

Add the bundle to your bundles.php:
```php
<?php

return [
    // ...
    Shapecode\Bundle\Doctrine\SessionHandlerBundle\ShapecodeDoctrineSessionHandlerBundle::class => ['all' => true],
    // ...
];
```

Update your database.

```bash
$ php bin/console doctrine:schema:update --force
```

Now you have to change your application config (default location of app/config/packages/framework.yaml).

```yml
framework:
    session:
        handler_id: Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler\DoctrineHandler
```

Done ;)
