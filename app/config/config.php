<?php

return array(

    /* -------------------------------------------------------------------------
     |
     | Application main configuration
     |
     | @see http://docs.slimframework.com/#Application-Settings
     |
       ---------------------------------------------------------------------- */

    'app' => array(

        /* ---------------------------------------------------------------------
         |
         | The mode to run application in. It does not effect the application behaviour.
         | Common values are: development, testing, production
         |
         | Use $app->getMode() to determine the application mode.
         |
         | Note: the application mode can be set using the environment variable
         | SLIM_MODE.
         |
           ------------------------------------------------------------------ */

        'mode' => getenv('app.mode') ?: 'development',

        /* ---------------------------------------------------------------------
         |
         | If debugging is enabled, Slim will use its built-in error handler to
         | display diagnostic information for uncaught Exceptions. If debugging
         | is disabled, Slim will instead invoke your custom error handler,
         | passing it the otherwise uncaught Exception as its first and only
         | argument.
         |
         | Set your custom error handler by providing a callback to \Slim\Slim::error()
         |
         | $app->error(function (\Exception $e) use ($app) {
         |    // handle the exception here
         | });
         |
         |
           ------------------------------------------------------------------ */

        'debug' => getenv('app.debug') !== false ? (bool)getenv('app.debug'): true,

        /* ---------------------------------------------------------------------
         |
         | Activates logging and sets the log level
         |
         | Fetch the log handler by calling $app->getLog()
         |
           ------------------------------------------------------------------ */

        'logging' => array(

            'enabled' => getenv('app.logging.enabled') !== false ? (bool)getenv('app.logging.enabled'): true,
            'level'   => \Slim\Log::DEBUG,

        ),

    ),

    /* -------------------------------------------------------------------------
     |
     | Database configuration
     |
     | Use to set commonly required values for database connection
     |
       ---------------------------------------------------------------------- */

    'database' => array(

        'driver' => getenv('database.driver') !== false ? getenv('database.driver') : 'mysql',

        'host' => getenv('database.host') !== false ? getenv('database.host') : 'localhost',

        'database' => getenv('database.database') !== false ? getenv('database.database') : 'development',

        'username' => getenv('database.username') !== false ? getenv('database.username') : 'user',

        'password' => getenv('database.password') !== false ? getenv('database.password') : 'password',

        'charset' => getenv('database.charset') !== false ? getenv('database.charset') : 'utf8',

        'collation' => getenv('database.collation') !== false ? getenv('database.collation') : 'utf8_unicode_ci',

        'prefix' => getenv('database.prefix') !== false ? getenv('database.prefix') : '',

    ),

    /* -------------------------------------------------------------------------
     |
     | Mail configuration
     |
     | Use to set commonly required values for mail handling.
     |
       ---------------------------------------------------------------------- */

    'mail' => array(

        'sender' => 'Example<office@example.com>',

    ),

);