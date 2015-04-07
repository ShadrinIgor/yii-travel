<?php

if( !empty( $_GET["ip"] ) )
{
    if( strpos( $_GET["ip"], ":" ) !== false )$_GET["ip"] = substr( $_GET["ip"], 0, strpos( $_GET["ip"], ":" ) );
    $_SERVER["REMOTE_ADDR"] = $_GET["ip"] ;
    $_SERVER["HTTP_USER_AGENT"] = $_GET["agent"];
    $_SERVER["QUERY_STRING"] = "";
    $_SERVER["REQUEST_URI"] = substr( $_SERVER["REQUEST_URI"], 0, strpos( $_SERVER["REQUEST_URI"], "?" ) );

    unset( $_SERVER["REDIRECT_QUERY_STRING"] );
    unset( $_SERVER["HTTP_X_REAL_IP"] );
    unset( $_SERVER["HTTP_X_FORWARDED_FOR"] );
    unset( $_SERVER["HTTP_X_PROXY_ID"] );
    unset( $_SERVER["HTTP_VIA"] );
}

if( checkMobile() == true )
{
   if( $_SERVER["HTTP_HOST"] != "wap.world-travel.uz" )Header("Location: http://wap.world-travel.uz".$_SERVER["REQUEST_URI"]);
}

header("cache-control: private, max-age = 86400");

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

/*$log = new CatLog();
$log->date2 = date("d.m.Y");
$log->action = "log";

$dd1 = urldecode($_SERVER["HTTP_REFERER"]);
//echo ;

$log->description = iconv("UTF-8", "CP1251", $dd1);
if( !$log->save() )print_r( $log->getErrors() );*/

echo lib_urldecode_u_to_w( $_SERVER["HTTP_REFERER"] );

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

function lib_urldecode_u_to_w($str)
{
    $replace_what=array("/\%D0%3F/si","/\%D1%3F/si","/\%20/si", "/\%D0%90/si", "/\%D0%91/si", "/\%D0%92/si", "/\%D0%93/si","/\%D0%94/si","/\%D0%95/si","/\%D0%81/si",
        "/\%D0%96/si","/\%D0%97/si","/\%D0%98/si","/\%D0%99/si","/\%D0%9A/si","/\%D0%9B/si","/\%D0%9C/si","/\%D0%9D/si","/\%D0%9E/si","/\%D0%9F/si","/\%D0%A0/si","/\%D0%A1/si","/\%D0%A2/si","/\%D0%A3/si","/\%D0%A4/si","/\%D0%A5/si","/\%D0%A6/si","/\%D0%A7/si","/\%D0%A8/si",
        "/\%D0%A9/si","/\%D0%AA/si","/\%D0%AB/si","/\%D0%AC/si","/\%D0%AD/si","/\%D0%AE/si","/\%D0%AF/si","/\%D0%86/si","/\%D0%87/si",
        "/\%D0%84/si","/\%D0%B0/si","/\%D0%B1/si","/\%D0%B2/si","/\%D0%B3/si","/\%D0%B4/si","/\%D0%B5/si","/\%D1%91/si","/\%D0%B6/si",
        "/\%D0%B7/si","/\%D0%B8/si","/\%D0%B9/si","/\%D0%BA/si","/\%D0%BB/si","/\%D0%BC/si","/\%D0%BD/si","/\%D0%BE/si","/\%D0%BF/si","/\%D1%80/si","/\%D1%81/si","/\%D1%82/si","/\%D1%83/si","/\%D1%84/si","/\%D1%85/si","/\%D1%86/si","/\%D1%87/si","/\%D1%88/si","/\%D1%89/si",
        "/\%D1%8A/si","/\%D1%8B/si","/\%D1%8C/si","/\%D1%8D/si","/\%D1%8E/si","/\%D1%8F/si","/\%D1%96/si","/\%D1%97/si","/\%D1%94/si",
        "/\%21/si","/\%22/si","/\%23/si","/\%24/si","/\%25/si","/\%26/si","/\%27/si","/\%28/si","/\%29/si","/\%2B/si","/\%3D/si","/\%3A/si","/\%2F/si","/\%3F/si", "/\%2C/si","/\+/si");
    $replace_with=array("И","ш"," ", "А","Б","В","Г","Д","Е","Ё","Ж","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш",
        "Щ","Ъ","Ы","Ь","Э","Ю","Я","І","Ї","Є","а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф",
        "х","ц","ч","ш","щ","ъ","ы","ь","э","ю","я","і","ї","є","!",'"',"№","^;","%",":","?","(",")","+","=",":","/","&",","," ");
    $str=str_replace("\r\n","",$str);
    $str=preg_replace($replace_what, $replace_with, $str);
    return $str;
};
