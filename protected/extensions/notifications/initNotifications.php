<?php

/**
 */

class initNotifications extends CApplicationComponent
{
    public $errors = array();
    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.notifications.models.*");
    }

    public function send( $key, $types, $userId, array $arrayParams = array() )
    {
        $status = false;

        $notification = NotificationsType::fetchAll(
                DBQueryParamsClass::CreateParams()
                    ->setConditions( "`key`=:key" )
                    ->setParams( array( ":key"=>$key ) )
            );

        if( !empty( $notification ) && sizeof( $notification )>0 )
        {
            $notificationMessage = NotificationsActions::fetchAll(
                DBQueryParamsClass::CreateParams()
                    ->setCache(0)
                    ->setConditions( "type_id=:type_id" )
                    ->setParams( array( ":type_id"=>$notification[0]->id ) )
            );

            if( !empty( $notificationMessage ) && sizeof( $notificationMessage )>0 )
            {
                for( $i=0;$i<sizeof( $notificationMessage );$i++ )
                {
                    if( strtolower( $notificationMessage[$i]->key_word ) == "info"  )
                    {
                        $NItem = new Notifications();
                        $NItem->type_id = $notification[0]->id;
                        $NItem->is_new = 1;
                        $NItem->action_id = $notificationMessage[$i]->id;

                        $message = $notificationMessage[$i]->mesage;
                        $subject = $notificationMessage[$i]->subject;
                        foreach( $arrayParams as $key=>$value )
                        {
                            $message = str_replace( "{".$key."}", $value, $message );
                            $subject = str_replace( "{".$key."}", $value, $subject );
                        }
                        $NItem->message = $message;
                        $NItem->subject = $subject;

                        if( !$notificationMessage[$i]->to_user )$NItem->user_id = $userId;
                            else
                        {
                            $toUserModel = CatalogUsers::findByAttributes( array("email"=>$notificationMessage[$i]->to_user) );
                            if( $toUserModel[0]->id >0 )$NItem->user_id = $toUserModel[0]->id;
                                else $this->errors[] = array( "Ошибка обработки действвий", "Событие: #".$notification[$i].", Действие: #".$notificationMessage[$i]." - емаил указыыный в поле TO_USER не зарегестрирован в базе" );
                        }

                        $NItem->date = time();
                        if( !empty( $arrayParams["catalog"] ) )$NItem->catalog = $arrayParams["catalog"];
                        if( !empty( $arrayParams["item_id"] ) )$NItem->item_id = $arrayParams["item_id"];

                        if( sizeof( $this->errors )==0 )
                            if( !$NItem->save() )$this->errors[] = print_r( $NItem->getErrors(), true );
                    }

                    if( strtolower( $notificationMessage[$i]->key_word ) == "mail"  )
                    {
                        if( !$notificationMessage[$i]->to_user )$userTo = CatalogUsers::fetch( $userId );
                        else
                        {
                            $toUserModel = CatalogUsers::findByAttributes( array("email"=>$notificationMessage[$i]->to_user) );
                            if( $toUserModel[0]->id >0 )$userTo= $toUserModel[0];
                                    else $this->errors[] = array( "Ошибка обработки действвий", "Событие: #".$notification[$i].", Действие: #".$notificationMessage[$i]." - емаил указыыный в поле TO_USER не зарегестрирован в базе" );
                        }

                        if( !empty( $userTo) && $userTo->id >0 )
                        {
                            $messages = $notificationMessage[$i]->mesage;
                            foreach( $arrayParams as $key=>$value )
                                $messages = str_replace( "{".$key."}", $value, $messages );

                            $this->mailto( $notificationMessage[$i]->subject, $notificationMessage[$i]->send_from, $userTo->email, $messages, $notificationMessage[$i]->copy_sender );
                            $status = true;
                        }
                            else
                            {
                                $this->errors[] = array( "Ошибка отправки сообщения", "Указан не верный ID пользователя");
                                return false;
                            }
                    }
                }
            }
              else $this->errors[] = array( "Ошибка события", "Для данного соьытия ( #".$notification[0]->id." ) не указы события");
        }
            else $this->errors[] = array( "Ошибка события", "Ошибка определения типа события");

        if( is_array( $this->errors ) && sizeof( $this->errors )>0 )
            throw new Exception( print_r( $this->errors, true) );

        return $status;
    }

    private function mailto($subject, $from = "", $to, $msg, $copy='', $template='main.tpl')
    {
        if( empty( $from ) )$from = Yii::app()->params['adminEmail'];
        $error = null;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=cp1251' . "\r\n";

        $headers .= 'Date: '.date("r")."\r\n";
        $headers .= 'To: '.$to." \r\n";
        $headers .= 'From: '.Yii::app()->params['titleName'].'<'.$from.'>' . "\r\n";
        if( !empty( $copy ) )$headers .= "Bcc: ".$copy."\r\n";

        if( $template && file_exists( "f/mails_template/".$template) )
        {
            $fullUrl = "f/mails_template/".$template;
            $file = fopen( $fullUrl, "r+" );
            $templateText = fread( $file, filesize( $fullUrl ) );
            fclose( $file );
            $msg = str_replace( "@cotent_text@", $msg, $templateText );
        }

        $headers = iconv("UTF-8", "cp1251", $headers);
        $msg = iconv("UTF-8", "cp1251", $msg);
        $subject = iconv("UTF-8", "cp1251", $subject);

   //echo $to.",".$subject.",".$msg.",".$headers;
        $res=@mail($to,$subject,$msg,$headers);

        if($res===false)$error="Произошла ошибка отправки сообщения на E-mail (<b>".$to."</b>). Проверте коректность вводимого E-mail и попробуйте снова.";

        return $error;
    }

    public function getList()
    {
        if( !Yii::app()->user->isGuest )
        {
            $list = Notifications::findByAttributes( array( "user_id"=>Yii::app()->user->id, "is_new"=>1 ) );
            $cout="";
            if( sizeof( $list )>0 )
            {
                $cout .= '<div id="notificationsBlock">';

                foreach( $list as $item )
                {
                    $cout .= '<div class="NBItem">
                                <div class="NHeader">'. $item->subject .'<div class="floatRight"><a href="#" class="NHide" id="'.$item->id.'">скрыть</a>&nbsp;&nbsp;&nbsp;<a href="#" class="NBdesc">подробнее</a></div></div>
                                <div class="displayNone">
                                    Дата: <font>'. SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) .'</font><br/>
                                    <div class="textAlignLeft">
                                        '.$item->message.'
                                    </div>
                                </div>
                            </div>';
                }

                $cout .='</div>
                         <script type="text/javascript">
                            $( document).ready( function()
                            {
                                $(".NHide").click( function()
                                {
                                    $.ajax({
                                            type: "GET",
                                            url: "'.SiteHelper::createUrl("/user/default/notificationHide/id") .'/"+this.id,
                                            success: function(msg){
                                                if( msg > 0 )
                                                {
                                                    $( $( "#"+msg )[0].parentNode.parentNode.parentNode ).remove();
                                                    if( $( "#notificationsBlock .NBItem" ).length == 0 )$( "#notificationsBlock" ).hide(400);
                                                }
                                            }
                                        });                                        
                                    return false;
                                })

                                $(".NBhide").click( function()
                                {
                                    $.ajax( "'.SiteHelper::createUrl("/user/notifications/show/id") .'/"+this.id );
                                    return false;
                                })

                                $(".NBdesc").click( function()
                                {
                                    var obj = $( this.parentNode.parentNode.parentNode ).find(".displayNone");
                                    if( obj.css("display") == \'none\' )
                                    {
                                        obj.show(500, "", function ()
                                        {
                                            $( this ).find(".textAlignLeft").show(300);
                                            $( this ).addClass("greyBack");
                                            $( this.parentNode ).find(".NBdesc").text( "кратко" );
                                        });
                                    }
                                    else
                                    {

                                        obj.find(".textAlignLeft").hide(300, \'\', function ()
                                        {
                                            $( this.parentNode ).removeClass("greyBack");
                                            $( this.parentNode ).hide(500);
                                            $( this.parentNode.parentNode).find(".NBdesc").text( "подробнее" );
                                        });
                                    }

                                    return false;
                                })
                            })
                        </script>';
            }

            return $cout;
        }

        return "";
    }

    public function setNotNews()
    {
        $id = (int) Yii::app()->request->getParam("id", 0);
        echo $id." - ".Yii::app()->user->id;
    }
}
?>
