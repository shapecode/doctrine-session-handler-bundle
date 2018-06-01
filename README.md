Shapecode - Doctrine Session Handler Bundle
============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/459ede02-b412-445e-9846-336cbfeb3fd5/mini.png)](https://insight.sensiolabs.com/projects/459ede02-b412-445e-9846-336cbfeb3fd5)
[![Latest Stable Version](https://poser.pugx.org/shapecode/doctrine-session-handler-bundle/v/stable)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![Total Downloads](https://poser.pugx.org/shapecode/doctrine-session-handler-bundle/downloads)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)
[![License](https://poser.pugx.org/shapecode/doctrine-session-handler-bundle/license)](https://packagist.org/packages/shapecode/doctrine-session-handler-bundle)

This bundle provides a Doctrine session handler to save sessions in a database.

Install instructions
--------------------------------

Installing this bundle can be done through these simple steps:

Add the bundle to your project as a composer dependency:

```bash
$ composer require shapecode/doctrine-session-handler-bundle
```

Add the bundle to your application kernel:
```php
<?php

// app/AppKernel.php
public function registerBundles()
{
	// ...
	$bundles = array(
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

Now you have to change your application config (default location of app/config/config.yml).

```yml
framework:
    session:
        # http://symfony.com/doc/current/reference/configuration/framework.html#handler-id
        # handler_id:  session.handler.native_file
        handler_id:  shapecode_doctrine_session_handler.handler
```

Done ;)
