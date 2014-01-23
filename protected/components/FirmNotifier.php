<?php

class FirmNotifier {
    static function onNewComment( $eventArray )
    {
        $event = $eventArray["event"]->sender;
        $arrayParams = $eventArray["params"];

        Yii::app()->notifications->send( "new_comment", array( "info" ), $event->firm_id->user_id->id, $arrayParams  );
    }
}