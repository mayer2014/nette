<?php

/**
 * Test: Nette\Latte\Engine: whitespace test I.
 */

use Nette\Latte;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$template = new Nette\Templating\Template;
$template->registerFilter(new Latte\Engine);

Assert::match(<<<EOD
qwerty

EOD

, (string) $template->setSource(<<<EOD
{contentType text}
qwerty

EOD
));


Assert::match(<<<EOD

asdfgh
EOD

, (string) $template->setSource(<<<EOD

{contentType text}
asdfgh
EOD
));
