<?php

class SubscribeCommand extends CConsoleCommand
{
    public function run($args)
    {
        $countLimit =SiteHelper::getConfig("subscribee_count_send");
        $emails = array();
        $countSend = 0;
        $res = SubscribeItems::findByAttributes( array( "status_id"=>2 ) );
        foreach( $res as $line )
        {
            // 1 - отправляем и зарегеным и подписчикам
            if( $line->users == 1 || $line->users == 2 ) //отправляем и зарегеным
            {
                $lisUsers = CatalogUsers::sql( "SELECT u.* FROM catalog_users u WHERE `active`=1 AND subscribe=1 AND !exists( SELECT id FROM subscribe_send WHERE email=u.email AND subscribe_id='".$line->id."' AND is_reg=1 ) LIMIT ".$countLimit );
                foreach( $lisUsers as $userLine )
                {
                    $emails[] = $userLine["EMAIL"];
                    mysql_query( "INSERT INTO subscribe_send( subscribe_id, user_id, email, is_reg) VALUES( '".$line->id."', '".$userLine["EMAIL"]."', '1' )" );
                    $countSend++;
                }
            }

            if( sizeof($emails)<$countLimit && ( $line->users == 1 || $line->users == 3 ) )//отправляем и подписчикам
            {
                $lisUsers = CatalogUsers::sql( "SELECT u.* FROM subscribe_users u WHERE `active`=1 AND subscribe=1 AND !exists( SELECT id FROM subscribe_send WHERE email=u.email AND subscribe_id='".$line->id."' AND is_reg=0 ) LIMIT ".( $countLimit - sizeof($emails) ) );
                foreach( $lisUsers as $userLine )
                {
                    $emails[] = $userLine["EMAIL"];
                    mysql_query( "INSERT INTO subscribe_send( subscribe_id, email, is_reg) VALUES( '".$line->id."', '".$userLine["email"]."', '0' )" );
                    $countSend++;
                }
            }

            if( $line->users == 4 ) // Отправка по спику
            {
                $usersList = trim( strip_tags( $line->users_list ) );
                if( !empty( $usersList ) )
                {
                    $listEmail = explode( ",", $usersList );
                    for( $m=0;$m<sizeof( $listEmail );$m++ )
                    {
                        $listEmail[$m] = trim( $listEmail[$m] );
                        list( $ext ) = mysql_fetch_array( mysql_query( "SELECT id FROM subscribe_send WHERE subscribe_id='".$line->id."' AND email='".$listEmail[$m]."'" ) );
                        if( empty( $ext ) && !empty( $listEmail[$m] ) )
                        {
                            $emails[] = $listEmail[$m];
                            mysql_query( "INSERT INTO sb_send( subscribe_id, email, is_reg) VALUES( '".$line->id."', '".$listEmail[$m]."', 0 )" );
                            $countSend++;
                        }
                    }
                }
            }

            if( sizeof( $emails )>0 )
            {
                for( $n = 0; $n<sizeof( $emails ) ;$n++ )
                {
                    $countSend ++;
                    $message = $line->description;
                    $message = str_replace( "</body>", "<img src=\"".SiteHelper::createUrl( "/site/subscribeOpen", array( "subscribe"=>$line->id, "email"=>$emails[$n] ) )."\" alt=\"\" style=\"width:0px;height:0px\" /></body>", $message );

                    SiteHelper::mailto( $line->subject, $line->from, $emails[$n], stripslashes( $message ) );
                }
            }

            // Сохраняем количество оптравленных, чтобы не считать каждый раз
            if( $countSend >0 )
            {
                $line->count_send += $countSend;
                $line->save();
            }

            // Если адресатов нет или их количество меньше чем лимит то финализируем рассылку
            if( sizeof( $emails )==0 || $countSend<$countLimit )
            {
                $line->status_id = 3;
                $line->save();
            }
        }

        function mailto($subject, $from='', $to, $msg, $hideCopyRecender="" )
        {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";

            $headers .= 'Date: '.date("r")."\r\n";
            $headers .= 'To: '.$to." \r\n";
            $headers .= 'From: Embassy Alliance Travel (www.embassyalliance.ru)<'.$from.'>' . "\r\n";
            $headers .= 'Reply-To: '.$from. "\r\n" ;
            if( !empty( $hideCopyRecender ) )$headers .= 'Bcc: '.$hideCopyRecender."\r\n";

            $headers = mb_convert_encoding($headers, 'CP1251','UTF8');
            $msg = mb_convert_encoding( $msg, 'CP1251','UTF8');
            $subject = mb_convert_encoding($subject, 'CP1251','UTF8' );

            $error="";
            $res=mail($to,$subject,$msg,$headers);
            if($res===false)$error="Произошла ошибка отправки сообщения на E-mail (<b>".$to."</b>). Проверте коректность вводимого E-mail и попробуйте снова.";
            return $error;
        }

    }
}