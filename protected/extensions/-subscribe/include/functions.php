<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 06.02.13
 * Time: 15:21
 * To change this template use File | Settings | File Templates.
 */
class functions
{
    static function check( $value )
    {
        return $value;
    }

    static function auth( $login, $password )
    {
        $login = functions::check( $login );
        $password = functions::check( $password );
        $error = "";
        if( !empty( $login ) && !empty( $password ) )
        {
            $user = users::getUser( 1, $login, $password );
            if( $user->id >0 )$_SESSION["s_user"] = $user->toArray();
                else $error = "Вы ввели не верные логин или пароль";
        }
            else $error = "Необходимо заполнить все поля";

        return $error;
    }

    static function logout()
    {
        unset( $_SESSION["s_user"] );
    }

    static function DBConnect()
    {
        require_once( "config.php" );
        mysql_connect( $db["host"], $db["login"], $db["password"] )or die( mysql_error() );
        mysql_select_db( $db["database"] );
        mysql_query( "SET names utf8;" );
    }

    static function DBClose()
    {
        mysql_close();
    }

    static function dateFormat( $time = 0, $format = "" )
    {
        if( $time>0 )
        {
            if( empty( $format ) )$format="d.m.Y";
            return date( $format, $time );
        }
    }

    static function getDopMenu( array $array )
    {
        $cout = "<div id=\"dopMenu\">";

        for( $i=0;$i<sizeof( $array );$i++ )
        {
            $cout .= "<div class=\"DPItem\"><a href=\"".$array[$i]["href"]."\">".$array[$i]["title"]."</a></div>";
        }

        $cout .= "</div>";
        return $cout;
    }

    static function getError( $error )
    {
        return "<div id=\"error\">".$error."</div>";
    }

    static function getMessage( $message )
    {
        return "<div id=\"message\">".$message."</div>";
    }
}
