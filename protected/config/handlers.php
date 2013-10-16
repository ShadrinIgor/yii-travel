<?php

return array(
    'onRegistration'=>array(
        array('UserNotifier', 'registration'),
    ),

    'onRegistrationConfirm'=>array(
        array('UserNotifier', 'registrationConfirm'),
    ),

    'onLogin'=>array(
        array('UserNotifier', 'updateDateVisit'),
    ),

    'onLostPassword'=>array(
        array('UserNotifier', 'lostPassword'),
    ),

    'onLostPasswordConfirm'=>array(
        array('UserNotifier', 'lostPasswordConfirm'),
    ),

    'onNewComment'=>array(
        array('ItemsNotifier', 'onNewComment'),
    ),

    // Добавление объявления
    'onAddItem'=>array(
        array('ItemsNotifier', 'onAddItem'),
    ),
    /*
        // Публикация объявления
        'onItemPublish'=>array(
            array('ItemsNotifier', 'onItemPublish'),
        ),

        // Прекращенная объявления
        'onItemPublishStop'=>array(
            array('ItemsNotifier', 'onItemPublishStop'),
        ),*/

);