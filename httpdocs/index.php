<?php

if( checkMobile() == true )
{
   if( $_SERVER["HTTP_HOST"] != "wap.world-travel.uz" )Header("Location: http://wap.world-travel.uz".$_SERVER["REQUEST_URI"]);
}

header("cache-control: private, max-age = 86400");

error_reporting(0);
ini_set('display_errors', 0);

// change the following paths if necessary


$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
date_default_timezone_set('Europe/Moscow');
/*define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_ENABLE_EXCEPTION_HANDLER', false);*/

if( $_SERVER["HTTP_HOST"] == "wap.world-travel.uz" )define('YII_SUBDOMAIN', "wap-");
                                               else define('YII_SUBDOMAIN', "");

require_once($yii);

Yii::setPathOfAlias('viewsLayouts', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."layouts");
Yii::setPathOfAlias('modules', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."modules");
Yii::setPathOfAlias('configPath', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."config");

Yii::createWebApplication($config)->run();


function checkMobile()
{
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ipod = strpos($user_agent,"iPod");
    $iphone = strpos($user_agent,"iPhone");
    $android = strpos($user_agent,"Android");
    $winphone = strpos($user_agent,"WindowsPhone");
    $operam = strpos($user_agent,"Opera M");
    $palm = strpos($user_agent,"webOS");
    $berry = strpos($user_agent,"BlackBerry");
    $mobile = strpos($user_agent,"Mobile");
	
	if ($ipod || $iphone || $android || $winphone || $operam || $palm || $berry || $mobile ) 
    {
        return true; 
    } 
    else
    {
        return false; 
    }
}
