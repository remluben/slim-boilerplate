<?php

/* -----------------------------------------------------------------------------
 | Application bootstrapping and routes initialization
   -------------------------------------------------------------------------- */

require __DIR__ . '/app/bootstrap/bootstrap.php';
require __DIR__ . '/app/Http/routes.php';

$app->run();