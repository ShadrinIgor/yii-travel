<?php

class SubscribesUzHelper
{
    static function sendEmail( $messageUserName, $messageUserEmail, $messageSubject, $messageText, $SubscribesUzGroup = 0, $sendType = 0 )
    {
        if( !empty( Yii::app()->params["SubscribesUz"] ) && filter_var($messageUserEmail, FILTER_VALIDATE_EMAIL) )
        {
            // Данные которые предостовляет Subscribes.uz
            $SubscribesUzHash = Yii::app()->params["SubscribesUz"]["hash"];
            $SubscribesUzUserEmail = Yii::app()->params["SubscribesUz"]["userEmail"];
            $SubscribesUzGroup = $SubscribesUzGroup > 0 ? $SubscribesUzGroup : Yii::app()->params["SubscribesUz"]["group"];

            // Данные которые предостовяет пользователь
            $messageUserName = trim( $messageUserName );
            $messageSubject = trim( $messageSubject );
            $messageText = trim( $messageText );

            if( !empty( $messageUserName ) && !empty( $messageSubject ) && !empty( $messageText ) )
            {
                $userHash = substr(md5(md5($SubscribesUzUserEmail . $SubscribesUzHash) . date("Y-m-d H")), 0, 15);
                $postFields = "message-user-name=" . $messageUserName . "&message-user-email=" . $messageUserEmail . "&message-subject=" . $messageSubject . "&message-text=" . $messageText;
                $postFields .= "&user-email=" . $SubscribesUzUserEmail . "&hash=" . $userHash . "&group=" . $SubscribesUzGroup;

                if( $sendType == 0 )$functionName = "addqueue";
                               else $functionName = "send";

                $url = Yii::app()->params["SubscribesUz"]["url"].$functionName;
                echo $url."<br/>";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
                curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s
                curl_setopt($ch, CURLOPT_POST, 1); // set POST method
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields); // add POST fields
                $result = curl_exec($ch); // run the whole process

                if ($result === FALSE) echo "cURL Error: " . curl_error($ch);
                curl_close($ch);
                echo $result;
            }
        }
            else throw new ExceptionClass('Error SubscribesUz: Не указанны данные для подключения');
    }
}