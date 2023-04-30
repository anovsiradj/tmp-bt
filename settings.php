<?php

require_once __DIR__ . '/php_packages/autoload.php';
require_once __DIR__ . '/php_packages/yiisoft/yii2/Yii.php';

define('BTEMPLATES_MODE', 'html');

(new \Whoops\Run)
->pushHandler(new \Whoops\Handler\PrettyPageHandler)
->register()
;
