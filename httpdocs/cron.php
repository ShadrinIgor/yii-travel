<?php

date_default_timezone_set('Europe/Moscow');
chdir(dirname(__FILE__).'/');
$root = dirname( __FILE__ ).'/';
$common = $root . '/../framework';
$config = require($root.'/../protected/config/cron.php');

error_reporting(0);
ini_set('display_errors', 0);

defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
require_once($common.'/yii.php');

/*
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_ENABLE_EXCEPTION_HANDLER', false);*/

Yii::setPathOfAlias('viewsLayouts', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."layouts");
Yii::setPathOfAlias('modules', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."modules");
Yii::setPathOfAlias('configPath', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."config");

$app = Yii::createConsoleApplication($config)->run();
