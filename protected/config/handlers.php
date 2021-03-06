<?php

return array(

    // Добавление объявлений пользователем
    'onAddFirm'=>array(
        array('AutoNotifier', 'onAddFirm'),
    ),

    'onAddTour'=>array(
        array('AutoNotifier', 'onAddTour'),
    ),

    'onAddFirmsItems'=>array(
        array('AutoNotifier', 'onAddFirmsItems'),
    ),

    'onAddFirmsService'=>array(
        array('AutoNotifier', 'onAddFirmsService'),
    ),

    'onAddFirmsBanners'=>array(
        array('AutoNotifier', 'onAddFirmsBanners'),
    ),

    // end of (Добавление объявлений пользователем)

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

    'onFirmNewComment'=>array(
        array('FirmNotifier', 'onNewComment'),
    ),

    // Добавление объявления
    'onAddItem'=>array(
        array('ItemsNotifier', 'onAddItem'),
    ),
	
    'onBannerRequest'=>array(
        array('BannerRequestNotifier', 'onBannerRequest'),
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