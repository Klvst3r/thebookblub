<?php
// require __DIR__ . '/vendor/autoload.php';

// use app\components\SmartyRenderer;

// var_dump(class_exists(SmartyRenderer::class));


require __DIR__ . '/vendor/autoload.php';

use app\components\SmartyRenderer;

$renderer = new SmartyRenderer();
$smarty = new ReflectionMethod($renderer, 'createSmarty');
$smarty->setAccessible(true);
$smartyInstance = $smarty->invoke($renderer);

var_dump($smartyInstance->isRegistered('class', 'Html')); // debe devolver true