<?php

class Notifier {
    static function registration_old($event)
    {
        echo "3*<br/>";
        $user = $event->sender;
        var_dump( $user );

        $d = new CatalogUsersConfirm();
        $d->user_id = 31;
        $d->confirm_key = "Igor";
        $d->date = time();
        $d->save();
    }
}