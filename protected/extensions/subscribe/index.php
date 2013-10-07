<?php
header("Content-type: text/html; charset=utf-8;");
header("Content-Transfer-Encoding: utf-8;");

ini_set("display_errors","on");
error_reporting( E_ALL );

@session_start();

require_once("include/models/users.php");
require_once( "include/functions.php");

// ===================================

if( !empty( $_GET["module"] ) )$modules = functions::check( $_GET["module"] );
                 else $modules = "subscribe";

if( !empty( $_GET["action"] ) )$action = functions::check( $_GET["action"] );
                else $action = "index";

if( !empty( $_POST["login"] ) || !empty( $_POST["password"] ) )
    $error = functions::auth( $_POST["login"], $_POST["password"] );

if( $action == "logout" )functions::logout();

// ===================================

functions::DBConnect();
include("template/header.php");

if( !empty( $_SESSION["s_user"] ) && $_SESSION["s_user"]["id"] >0 )
{
    if( $modules == "subscribe" )include( "modules/subscribe.php" );
    if( $modules == "config" )include( "modules/config.php" );
}
    else include( "login.php" );

include("template/footer.php");
functions::DBClose();