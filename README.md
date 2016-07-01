Shapecode - Doctrine Session Handler Bundle
============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/459ede02-b412-445e-9846-336cbfeb3fd5/mini.png)](https://insight.sensiolabs.com/projects/459ede02-b412-445e-9846-336cbfeb3fd5)
[![Dependency Status](https://www.versioneye.com/user/projects/5776d31e68ee07004d8f8eae/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/5776d31e68ee07004d8f8eae)
[![Latest Stable Version](https://poser.pugx.org/shapecode/doctrine-session-handler-bundle/v/stable)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Total Downloads](https://poser.pugx.org/shapecode/doctrine-session-handler-bundle/downloads)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![License](https://poser.pugx.org/shapecode/doctrine-session-handler-bundle/license)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)

This bundle provides a Doctrine session handler to save sessions in a database.

Install instructions
--------------------------------

Installing this bundle can be done through these simple steps:

Add the bundle to your project as a composer dependency:

```json
// composer.json
{
    "require": {
        "shapecode/doctrine-session-handler-bundle": "~1.0"
    }
}
```

or ...

```bash
$ composer require shapecode/doctrine-session-handler-bundle:~1.0
```

Then do a composer update.

```bash
$ composer update
```

Add the bundle to your application kernel:
```php
<?php

// application/ApplicationKernel.php
public function registerBundles()
{
	// ...
	$bundle = array(
		// ...
        new Shapecode\Bundle\Doctrine\SessionHandlerBundle\ShapecodeDoctrineSessionHandlerBundle,
	);
    // ...

    return $bundles;
}
```

Update your database.

```bash
$ php bin/console doctrine:schema:update --force
```

Now you have to change your application config.

```yml
framework:
    session:
        # http://symfony.com/doc/current/reference/configuration/framework.html#handler-id
        # handler_id:  session.handler.native_file
        handler_id:  shapecode_doctrine_session_handler.handler
```

You are done ;)
