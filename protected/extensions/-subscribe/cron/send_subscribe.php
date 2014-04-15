<?php
header("Content-type: text/html; charset=utf-8;");
header("Content-Transfer-Encoding: utf-8;");

db_connect();

$deleteIds = "";
$countSend = 0;
$res = mysql_query( "SELECT * FROM sb_subscribe WHERE status=2 ORDER BY id LIMIT 1" );
while( $line = mysql_fetch_array( $res ) )
{
    list( $countLimit )=mysql_fetch_array( mysql_query("SELECT value FROM sb_config WHERE `key`='count_send'") );

    $emails = array();
    if( $line["sender_type"] == 1 ) // Отпрвка всем
    {
        $users = mysql_query( "SELECT u.* FROM b_user u WHERE `ACTIVE`='Y' AND !exists( SELECT id FROM sb_send WHERE user_id=u.ID AND subscribe_id='".$line["id"]."' ) LIMIT ".$countLimit );
        while( $userLine = mysql_fetch_array( $users ) )
        {
            $emails[] = $userLine["EMAIL"];
            mysql_query( "INSERT INTO sb_send( subscribe_id, user_id) VALUES( '".$line["id"]."', '".$userLine["ID"]."' )" );
            $countSend++;
        }
    }

    if( $line["sender_type"] == 2 ) // Отправка по региону
    {
        if( !empty( $line["sender_region"] ) )
        {
            $listRegion = "";
            $arrRegion = explode( ",", $line["sender_region"] );
            for( $m=0;$m<sizeof( $arrRegion );$m++ )
            {
                if( !empty( $listRegion ) )$listRegion.=" OR ";
                $listRegion.=" b.UF_COUNTRY='".$line["sender_region"]."'";
            }

            //
            $sql = "SELECT u.* FROM b_user u, b_uts_user b WHERE u.`ACTIVE`='Y' AND b.VALUE_ID=u.ID AND ( ".$listRegion." ) AND !exists( SELECT id FROM sb_send WHERE user_id=u.ID AND subscribe_id='".$line["id"]."' ) LIMIT ".$countLimit;
            $users = mysql_query( $sql );
            echo $sql;
            while( $userLine = mysql_fetch_array( $users ) )
            {
                $emails[] = $userLine["EMAIL"];
                mysql_query( "INSERT INTO sb_send( subscribe_id, user_id) VALUES( '".$line["id"]."', '".$userLine["ID"]."' )" );
                $countSend++;
            }
        }
    }

    if( $line["sender_type"] == 3 ) // Отправка по спику
    {
        if( !empty( $line["sender_list"] ) )
        {
            $listEmail = explode( ",", $line["sender_list"] );
            for( $m=0;$m<sizeof( $listEmail );$m++ )
            {
                list( $ext ) = mysql_fetch_array( mysql_query( "SELECT id FROM sb_send WHERE subscribe_id='".$line["id"]."' AND user_email='".$listEmail[$m]."'" ) );
                if( empty( $ext ) )
                {
                    $emails[] = $listEmail[$m];
                    mysql_query( "INSERT INTO sb_send( subscribe_id, user_email) VALUES( '".$line["id"]."', '".$listEmail[$m]."' )" );
                    $countSend++;
                }
            }
        }
    }

    if( sizeof( $emails )>0 )
    {
        $message = $line["message"];
        $firstEmail = $emails[0];

        unset( $emails[0] );
        $othersEmail = implode( ",", $emails );
        mailto( $line["subject"], $line["from"], $firstEmail, stripslashes( $message ), $othersEmail );
    }

    // Если адресатов нет или их количество меньше чем лимит то финализируем рассылку
    if( sizeof( $emails )==0 || $countSend<$countLimit )mysql_query( "UPDATE sb_subscribe SET status=4 WHERE id='".$line["id"]."'" );

    if( !empty( $countSend ) )mysql_query( "UPDATE sb_subscribe SET count_send= count_send + ".$countSend." WHERE id=".$line["id"] );
}
db_close();

function mailto($subject, $from='', $to, $msg, $hideCopyRecender="" )
{
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";

    $headers .= 'Date: '.date("r")."\r\n";
    $headers .= 'To: '.$to." \r\n";
    $headers .= 'From: Embassy Alliance Travel (www.embassyalliance.ru)<'.$from.'>' . "\r\n";
    if( !empty( $hideCopyRecender ) )$headers .= 'Bcc: '.$hideCopyRecender."\r\n";

    $headers = mb_convert_encoding($headers, 'CP1251','UTF8');
    $msg = mb_convert_encoding( $msg, 'CP1251','UTF8');
    $subject = mb_convert_encoding($subject, 'CP1251','UTF8' );

    //echo $to."<br/>".$subject."<br/>".$msg."<br/>".$headers."<hr/>";
    $res=mail($to,$subject,$msg,$headers);
    if($res===false)$error="Произошла ошибка отправки сообщения на E-mail (<b>".$to."</b>). Проверте коректность вводимого E-mail и попробуйте снова.";
    return $error;
}

function db_connect( )
{
    $DBHost = "";
    $DBLogin = "";
    $DBPassword = "";
    $DBName = "";

    include( "../bitrix/php_interface/dbconn.php" );
    $result=mysql_connect($DBHost,$DBLogin,$DBPassword) or die("Error connect to database".mysql_error());
    if( $result === false )echo "Произошла ошибка подключения";

    $result = mysql_select_db($DBName);
    if( $result === false )echo "Произошла ошибка выбора базы";
    mysql_query("set names utf8;")or die(mysql_error());
}

function db_close()
{
    mysql_close();
}

?>