<?php

date_default_timezone_set('Europe/Moscow');
chdir(dirname(__FILE__).'/');
$root = dirname( __FILE__ ).'/';
$common = $root . 'framework';
$config = require($root.'protected/config/cron.php');
require_once($common.'/yii.php');

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_ENABLE_EXCEPTION_HANDLER', false);

$app = Yii::createConsoleApplication($config)->run();
