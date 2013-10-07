<?php

class ItemsNotifier {
    static function onNewComment( $eventArray )
    {
        $event = $eventArray["event"]->sender;
        $arrayParams = $eventArray["params"];

        // Отправляем письмо для подтверждения Email
        if( $event->user_id>0 )Yii::app()->notifications->send( "new_message", array( "info" ), $event->user_id, $arrayParams  );
    }

    static function onAddItem( $eventArray )
    {
        $event = $eventArray["event"]->sender;
        $arrayParams = $eventArray["params"];

        // Отправляем письмо для подтверждения Email
        if( $event->user_id>0 )Yii::app()->notifications->send( "add_item", array( "info" ), $event->user_id, $arrayParams  );
    }
}