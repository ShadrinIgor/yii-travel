<?php

class UserNotifier
{
    static function registration( $eventArray )
    {
        $event = $eventArray["event"];
        $user = $event->sender;
        $arrayParams = $eventArray["params"];

        // добавляем в базу запись о необходимости подтверждения регистрации
        $confim = new CatalogUsersConfirm();
        $confim->user_id = $user->id;
        $confim->date = time();
        $confim->confirm_key = substr( md5( $user->email.time() ), 0, 8 );
        $confim->type = "registration";
        $confim->save();

        SiteHelper::setLog( "catalog_users", "registration", $user->id );

        if( $confim->hasErrors() && sizeof( $confim )>0 )
        {
            $errors = "Ошибка сохранение записи для подтверждения регистрации: ";
            foreach( $confim->getErrors() as $data )
                foreach( $data as $key=>$value )$errors .= $value.", ";

            throw new Exception( $errors );
        }
            else
        {
            // Ставим его в очередь на проверку, если пользователь не подтвердил в течении одного дня, спрашиваем почему он этого не сделал
            AutoNotifier::addInNotificationsQueue("catalog_users", $user->id, 0 );

            $arrayParams = array_merge( $arrayParams, [ "link"=> SiteHelper::createUrl( "/user/default/confirm", [ "confirm_key"=>$confim->confirm_key ]  )  ]);
            // Отправляем письмо для подтверждения Email
            Yii::app()->notifications->send( "registration_confirm", [ "mail" ], $user->id, $arrayParams );
        }
    }

    static function registrationConfirm( $event )
    {
        $confirm = $event->sender;
        if( $confirm->id >0 )
        {
            $user = $confirm->user_id;
            // Изменяем статус пользователя
            $user->active = 1;
            $user->save();
            if( $user->hasErrors() && sizeof( $user )>0 )
            {
                $errors = "Ошибка сохранение подтвержджения регистрации: ";
                foreach( $user->getErrors() as $data )
                    foreach( $data as $key=>$value )$errors .= $value.", ";

                throw new Exception( $errors );
            }
                else
            {
                SiteHelper::setLog( "catalog_users", "registration_confirm", $user->id );
                // Удаляем запись в базе о необходимости подтверждения
                if( $confirm->id>0 )$confirm->delete();

                // Ставим его в очередь на проверку, если пользователь не подтвердил в течении одного дня, спрашиваем почему он этого не сделал
                AutoNotifier::delInNotificationsQueue("catalog_users", $user->id);
                AutoNotifier::addInNotificationsQueue("catalog_users_confirm", $user->id, 0 );

                // Отправляем письмо для подтверждения Email
                Yii::app()->notifications->send( "registration_successfully", [ "mail" ], $user->id );
            }
        }

    }

    static function updateDateVisit( $event )
    {
        // Работа с обущающими сесиями
        TrainingsHelper::run();

        $user = $event->sender;
        $user->last_visit = time();
        $user->date_login = date("Y-m-d");

        if( !$user->save() )
        {
            throw new Exception(["Error update last visit", "Error update last visit"]);
        }
    }

    static function lostPassword( $event )
    {
        $user = $event->sender;

        // добавляем в базу запись о необходимости подтверждения регистрации
        $confim = new CatalogUsersConfirm();
        $confim->user_id = $user->id;
        $confim->date = time();
        $confim->confirm_key = substr( md5( $user->email.time() ), 0, 8 );
        $confim->type = "lostpassword";
        $confim->save();
        SiteHelper::setLog( "catalog_users", "lost_password_request", $user->id );

        if( $confim->hasErrors() && sizeof( $confim )>0 )
        {
            $errors = "Ошибка сохранение подтвержджения восстановление пароля: ";
            foreach( $confim->getErrors() as $data )
                foreach( $data as $key=>$value )$errors .= $value.", ";

            throw new Exception( $errors );
        }
            else
        {
            $arrayParams = [ "link"=> SiteHelper::createUrl( "/user/default/LostConfirm", [ "key"=>$confim->confirm_key ] ) ];
            // Отправляем письмо для подтверждения Email
            Yii::app()->notifications->send( "lostpassword_request", [ "mail" ], $user->id, $arrayParams );
        }
    }

    static function lostPasswordConfirm( $event )
    {
        $userSender = $event->sender[0];

        $user = CatalogUsers::fetch( $userSender->user_id->id );
        $user->password = md5( $_POST["CatalogUsersLostConfirm"]["password"] );

        $user->save();
        SiteHelper::setLog( "catalog_users", "lost_password", $user->id );
        if( $user->hasErrors() && sizeof( $user )>0 )
        {
            $errors = "Ошибка сохранение нового пароля: ";
            foreach( $user->getErrors() as $data )
                foreach( $data as $key=>$value )$errors .= $value.", ";

            throw new Exception( $errors );
        }
            else
        {
            // Отправляем письмо уведомления о смене пароля
            Yii::app()->notifications->send( "lostpassword_save", [ "mail" ], $user->id );
        }
    }
}