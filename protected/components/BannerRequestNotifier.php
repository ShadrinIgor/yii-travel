<?php

class BannerRequestNotifier {
    static function onBannerRequest( $eventArray )
    {
        $event = $eventArray["event"]->sender;
        $arrayParams = $eventArray["params"];

        // Отправляем письмо для подтверждения Email
        if( $event->user_id>0 )Yii::app()->notifications->send( "banner_request", array( "info" ), $event->user_id, $arrayParams  );
    }
}