<?php

/**
 * Test: Nette\Diagnostics\Debugger errors and shut-up operator.
 * @exitCode   255
 * @httpCode   500
 * @outputMatch exception 'ErrorException' with message 'Call to undefined function missing_function()' in %A%
 */

use Nette\Diagnostics\Debugger;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


Debugger::$productionMode = FALSE;
header('Content-Type: text/plain');

Debugger::enable();

@missing_function();
