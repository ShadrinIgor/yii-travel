<?php

class SubscribeCommand extends CConsoleCommand
{
    public function run($args)
    {
        $countLimit = SiteHelper::getConfig("subscribee_count_send");
        $emails = array();
        $countSend = 0;
        $res = SubscribeItems::findByAttributes( array( "status_id"=>2 ) );
        foreach( $res as $line )
        {
            // 1 - отправляем и зарегеным и подписчикам
            if( $line->users == 1 || $line->users == 2 ) //отправляем и зарегеным
            {
                $lisUsers = CatalogUsers::sql( "SELECT u.* FROM catalog_users u WHERE `active`=1 AND subscribe=1 AND !exists( SELECT id FROM subscribe_send WHERE email=u.email AND item_id='".$line->id."' AND is_reg=1 ) LIMIT ".$countLimit );
                foreach( $lisUsers as $userLine )
                {
                    $emails[] = array( "email"=>$userLine["email"], "name"=> $userLine["name"] );
                    $newSend = new SubscribeSend();
                    $newSend->item_id = $line->id;
                    $newSend->user_id = $userLine["id"];
                    $newSend->email = $userLine["email"];
                    $newSend->is_reg = 1;
                    if( !$newSend->save() )
                        print_r( $newSend->getErrors() );
                }
            }

            if( sizeof($emails)<$countLimit && ( $line->users == 1 || $line->users == 3 ) )//отправляем и подписчикам
            {
                $lisUsers = CatalogUsers::sql( "SELECT u.* FROM subscribe_users u WHERE !exists( SELECT id FROM subscribe_send WHERE email=u.email AND item_id='".$line->id."' AND is_reg=0 ) LIMIT ".( $countLimit - sizeof($emails) ) );
                foreach( $lisUsers as $userLine )
                {
                    $emails[] = array( "email"=>$userLine["email"], "name"=> $userLine["name"] );
                    $newSend = new SubscribeSend();
                    $newSend->item_id = $line->id;
                    $newSend->user_id = null;
                    $newSend->email = $userLine["email"];
                    $newSend->is_reg = 0;
                    if( !$newSend->save() )
                        print_r( $newSend->getErrors() );
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
                        $ext = SubscribeSend::findByAttributes( array( "item_id"=>$line->id, "email"=>$listEmail[$m] ) );
                        if( sizeof($ext) == 0 )
                        {
                            $emails[] = array( "email"=>$listEmail[$m], "name"=>"пользователь" );
                            $newSend = new SubscribeSend();
                            $newSend->item_id = $line->id;
                            $newSend->user_id = null;
                            $newSend->email = $listEmail[$m];
                            $newSend->is_reg = 0;
                            if( !$newSend->save() )
                                print_r( $newSend->getErrors() );
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
                    $message = str_replace( "@user_name@", $emails[$n]["name"], $message );

                    SiteHelper::mailto( $line->subject, $line->from, $emails[$n]["email"], stripslashes( $message ), "", "", array( "<!-- @openSubscribeLink@ -->"=>"<img src=\"".Yii::app()->params["baseUrl"]."site/subscribeOpen/subscribe/".$line->id."/email/".$emails[$n]["email"]."\" alt=\"\" style=\"width:0px;height:0px\" />" ) );
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

    }
}