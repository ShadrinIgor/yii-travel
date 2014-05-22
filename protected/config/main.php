<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Yii-news',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    // Название темы
    'theme' => 'classic',
    // preloading 'log' component
    'preload'=>array('log'),

    'defaultController'=>'site',

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'modules.catalog.models.*',
        'modules.catalog.components.*',
        'application.components.ImageHandler.CImageHandler',
        'application.components.CCApplicationComponent',
        'ext.favorites.models.*',
        'ext.banners.models.*',
        'application.modules.subscribe.models.*',
//        'ext.eoauth.*',
//        'ext.eoauth.lib.*',
//        'ext.lightopenid.*',
//        'ext.eauth.services.*',
    ),

    'modules'=>array(
        'user', 'console', 'catalog', 'find', 'subscribe',
        // uncomment the following to enable the Gii tool


        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'6223772',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),

    ),

    // application components
    'components'=>array(

        'cache'=>array('class'=>'system.caching.CFileCache'),

        // CImageHandler
        'ih'=>array(
            'class'=>'CImageHandler',
        ),

        // Favorites
        'favorites'=>array(
            'class'=>'initFavorites',
        ),

        // Banners
        'banners'=>array(
            'class'=>'BannerInit',
        ),

        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules'=>array(
                ''=>'site/index',
                '<lang:(en)>'=>'site/index',

                '<lang:(en)>/<controller:\w+>'=>'<controller>',
                '<lang:(en)>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<lang:(en)>/<controller:\w+>/<action:\w+>/<slug:[\w-]+>.html'=>'<controller>/<action>',

                '<controller:\w+>/<action:\w+>/<slug:[\w-]+>.html'=>'<controller>/<action>',
                '<slug:[\w-]+>_<id:\d+>_<controller:(news)>.html'=> '<controller>',
//                '<controller:(tag)>/<action:(list)>.html'=> '<controller><action>', // /<action:(Tags)>
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

/*                '<slug:\w+>-<country:\w+>_<controller:(category)>_<page:\d+>.html'=> '<controller>',
                '<slug:\w+>-<country:\w+>_<controller:(category)>.html'=> '<controller>',
                '<slug:\w+>_<controller:(category)>_<page:\d+>.html'=> '<controller>',
                '<slug:\w+>_<controller:(category)>.html'=> '<controller>',

                '<slug:\w+>_<id:\d+><controller:(tag)>_<page:\d+>.html'=>'<controller>',
                '<slug:\w+>_<id:\d+><controller:(tag)>.html'=> '<controller>',

                '<country:\w+>-<controller:(people)>-<category:\w+>.html'=> '<controller>',

                '<country:\w+>-<controller:(people)>_<page:\d+>.html'=> '<controller>',
                '<country:\w+>-<controller:(people)>.html'=> '<controller>',

                '<controller:(people)>-<category:\w+>_<page:\d+>.html'=> '<controller>',
                '<controller:(people)>-<category:\w+>.html'=> '<controller>',
                '<slug:\w+>_<controller:(people)>_<action:(desc)>.html'=> '<controller>/desc',*/

                'gardens.html' => '/gardens',

                'registration.html'=> 'user/default/Registration',
                'lost.html'=> 'user/default/lost',
                'logout.html'=> 'user/default/logout',

                '<slug:\w+>.html'=> 'page',
            ),
        ),

        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),

        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'services' => array( // You can change the providers and their classes.
                'google' => array(
                    'class' => 'GoogleOpenIDService',
                ),
                'yandex' => array(
                    'class' => 'YandexOpenIDService',
                ),
                /*
                                'twitter' => array(
                                    // register your app here: https://dev.twitter.com/apps/new
                                    'class' => 'TwitterOAuthService',
                                    'key' => 'fZOlqQCLbHGmQ5I7Swt0w',
                                    'secret' => 'FbxAxumTvWBXItYhR2K7wWQAdlaZyjeZn2svkp2PJW8',
                                ),
                                'google_oauth' => array(
                                    // register your app here: https://code.google.com/apis/console/
                                    'class' => 'GoogleOAuthService',
                                    'client_id' => '...',
                                    'client_secret' => '...',
                                    'title' => 'Google (OAuth)',
                                ),
                */
                'facebook' => array(
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'FacebookOAuthService',
                    'client_id' => '428081060609322',
                    'client_secret' => '2a900f700e80f38e0a77b700c6134f5e',
                ),
                /*
                                'linkedin' => array(
                                    // register your app here: https://www.linkedin.com/secure/developer
                                    'class' => 'LinkedinOAuthService',
                                    'key' => '0ceu3iv6hcs3',
                                    'secret' => 'dlSpylUztNZ5BvJm',
                                ),
                */
                'github' => array(
                    // register your app here: https://github.com/settings/applications
                    'class' => 'GitHubOAuthService',
                    'client_id' => '5aa1eb3c4e716ddf0731',
                    'client_secret' => 'bb636f402cc8155223e7a15a266eb2efb0eefb49',
                ),
                'vkontakte' => array(
                    // register your app here: http://vkontakte.ru/editapp?act=create&site=1
                    'class' => 'VKontakteOAuthService',
                    'client_id' => '3463515',
                    'client_secret' => '9ibyCqnBBzqpMK8P41OU',
                ),
                'mailru' => array(
                    // register your app here: http://api.mail.ru/sites/my/add
                    'class' => 'MailruOAuthService',
                    'client_id' => '700152',
                    'client_secret' => 'a65b90c87b21cfd93eb8ecf9bb6f0496',
                ),
                /*
                                'moikrug' => array(
                                    // register your app here: https://oauth.yandex.ru/client/my
                                    'class' => 'MoikrugOAuthService',
                                    'client_id' => '813f1019ee444c10bcc8f355e74ef174',
                                    'client_secret' => '6e34781039ad4731a943a201707f0659',
                                ),
                */
                'odnoklassniki' => array(
                    // register your app here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
                    'class' => 'OdnoklassnikiOAuthService',
                    'client_id' => '163432192',
                    'client_public' => 'CBAIMOLKABABABABA',
                    'client_secret' => '5B642CA15C5B5F93AEE463E0',
                    'title' => 'Odnokl.',
                ),
            ),
        ),

        // uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=yii_travel',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1',
            'charset' => 'utf8',
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),
                // uncomment the following to show log messages on web pages

                array(
                    'class'=>'CWebLogRoute',
                ),
            ),
        ),
        'clientScript' => array(
            'class' => 'ext.minScript.components.ExtMinScript',
            /*
                        'scriptMap'=>array(
                            'jquery.js'=>'/js/all.js',
                            'jquery.easing.1.3.js'=>'/js/all.js',
                            'functions.js'=>'/js/all.js',
                            'lightbox.js'=>'/js/all.js',
                            )
            */
        ),

        'assetManager'=>array(
            'basePath'=>realpath(dirname(dirname(dirname(__FILE__))).'/httpdocs/assets'),
        ),

        'messages'=>array(
            'class'            => 'DBCMessageSource',
            'forceTranslation' => true,
        ),

        'banners'=>array(
            'class'     => 'ext.banners.BannerInit'
        ),

        'page'=>array(
            'class'     => 'ext.page.PageInit',
            'tag_params' =>
                array(
                    "first_page" =>
                        array
                        (
                            "catalog_country"=>array( "/Country/description", 5 ),
                            "catalog_tours"=>array( "/tours/description", 5, "active=1" ),
                            "catalog_tours_category"=>array( "/tours/category", 5, "owner>0" ),
//                            "catalog_hotels"=>array( "/hotels/description", 5 ),
                            "catalog_kurorts"=>array( "/resorts/description", 5, "active=1" ),
                            "catalog_kurorts_category"=>array( "/resorts/category", 5, "owner>0" ),
                            "catalog_info"=>array( "/touristInfo/description", 5 ),
                            "catalog_info_category"=>array( "/touristInfo/category", 5, "owner>0" ),
                            "catalog_content"=>array( "/news/description", 5, "category_id=2" ),
                            "catalog_firms"=>array( "/travelAgency/description", 5 ),
                            "catalog_items_category"=>array( "/adsUsers", 5 ),
                        ),

                    "country" =>
                        array
                        (
                            "catalog_country"=>array( "/Country/description", 15 ),
                            "catalog_tours"=>array( "/tours/description", 15, "active=1" ),
                            "catalog_tours_category"=>array( "/tours/category", 15, "owner>0" ),
                            "catalog_kurorts_category"=>array( "/resorts/category", 5, "owner>0" ),
                            "catalog_info_category"=>array( "/touristInfo/category", 5, "owner>0" ),
                        ),

                    "tours" =>
                        array
                        (
                            "catalog_country"=>array( "/Country/description", 15 ),
                            "catalog_tours"=>array( "/tours/description", 25, "active=1" ),
                            "catalog_tours_category"=>array( "/tours/category", 35, "owner>0" ),
                        ),


                    "hotels" =>
                        array
                        (
                            "catalog_country"=>array( "/Country/description", 25 ),
                            "catalog_hotels"=>array( "/hotels/description", 65 ),
                        ),

                    "resorts" =>
                        array
                        (
                            "catalog_country"=>array( "/Country/description", 25 ),
                            "catalog_kurorts"=>array( "/resorts/description", 25, "active=1" ),
                            "catalog_kurorts_category"=>array( "/resorts/category", 55, "owner>0" ),
                        ),

                    "touristInfo" =>
                        array
                        (
                            "catalog_info"=>array( "/touristInfo/description", 25 ),
                            "catalog_info_category"=>array( "/touristInfo/category", 35, "owner>0" ),
                        ),

                    "news" =>
                        array
                        (
                            "catalog_content"=>array( "/news/description", 45, "category_id=2" ),
                        ),

                    "travelAgency" =>
                        array
                        (
                            "catalog_firms"=>array( "/travelAgency/description", 55 ),
                        ),

                    "adsUsers" =>
                        array
                        (
                            "catalog_items"=>array( "/adsUsers/description", 25 ),
                            "catalog_items_category"=>array( "/adsUsers", 35 ),
                        ),

                    "work" =>
                        array
                        (
                            "catalog_work"=>array( "/work/description", 25 ),
                            "catalog_work_category"=>array( "/work", 35 ),
                        ),
                )
        ),

        'textAnalysis'=>array(
            'class'     => 'ext.textAnalysis.AnalysisInit'
        ),

        'notifications'=>array(
            'class'     => 'ext.notifications.initNotifications'
        ),

        'payment' => array(
            'class' => 'ext.activemerchant.ActiveMerchant',
            'mode' => 'test', //live
            'gateways' => array(
                'PaypalExpress' => array(
                    'login'     => 'blabla',
                    'password'  => 'password',
                    'signature' => '....',
                    'currency'  => 'USD'
                ),
                'Paypal' => array(
                    'login'     => 'blabla2',
                    'password'  => 'password2',
                    'signature' => '.....',
                    'currency'  => 'USD'
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'info@world-travel.uz',
        'supportEmail'=>'support@world-travel.uz',
        'baseUrl' => 'http://yii-travel.loc/',
        'wap-baseUrl' => 'http://yii-travel.loc/',
        'mail-server' => 'world-travel.uz',
        'mail-host' => 'world-travel.uz',
        'mail-log' => 'info@world-travel.uz',
        'mail-pass' => '15e2oYUn',
        'images' => array(
            "default" => array(
                "1" => array( "width"=>1300, "height"=>1300 ),
                "2" => array( "width"=>200, "height"=>200 ),
                "3" => array( "width"=>100, "height"=>100 )
            )
        ),
        'images_quality'=>70, // Работает только для JPG
        "catalogList"=>array(
            array( "title"=>"объявления",
                "items"=>array
                (
                    array( "title"=>"Фирмы", "controller"=>"catalog", "params"=>"catalog=CatalogFirms" ),
                    array( "title"=>"Работа", "controller"=>"catalog", "params"=>"catalog=CatalogWork" ),
                    array( "title"=>"ч. объявления", "controller"=>"catalog", "params"=>"catalog=CatalogItems" ),
                    array( "title"=>"Информация", "controller"=>"catalog", "params"=>"catalog=CatalogInfo" ),
                    array( "title"=>"Курорты", "controller"=>"catalog", "params"=>"catalog=CatalogKurorts" ),
                    array( "title"=>"Туры", "controller"=>"catalog", "params"=>"catalog=CatalogTours" ),
                    array( "title"=>"Группы", "controller"=>"catalog", "params"=>"catalog=CatalogSections" ),
                ),
            ),

            array( "title"=>"Баннеры",
                "items"=>array
                (
                    array( "title"=>"Баннеры", "controller"=>"catalog", "params"=>"catalog=CatalogFirmsBanners" ),
                    array( "title"=>"Запросы на баннер", "controller"=>"catalog", "params"=>"catalog=CatalogBannerRequest" ),
                ),
            ),
            array( "title"=>"Заявки на баннер", "controller"=>"catalog", "params"=>"catalog=CatalogBannerRequest" ),
            array( "title"=>"Сотрудничество",
                "items"=>array
                (
                    array( "title"=>"Предложение", "controller"=>"catalog", "params"=>"catalog=CatalogCooperation" ),
                    array( "title"=>"Категории", "controller"=>"catalog", "params"=>"catalog=CatalogCooperationCategory" ),
                ),
            ),
            array( "title"=>"Пользователи", "controller"=>"catalog", "params"=>"catalog=CatalogUsers" ),
            array( "title"=>"Текст. информация", "controller"=>"catalog", "params"=>"catalog=CatalogContent" ),
            array( "title"=>"Рабочие столы", "controller"=>"catalog", "params"=>"catalog=CatalogDesktops" ),
            array( "title"=>"Выставление Slug", "controller"=>"setSlug", "params"=>"" ),
            array( "title"=>"Проверка description", "controller"=>"checkDescription", "params"=>"" ),


            // Параметры
            array( "title"=>"Данные",
                "items"=>array
                (
                    array( "title"=>"Страницы", "controller"=>"catalog", "params"=>"catalog=CatalogPages" ),
                    array( "title"=>"Категории фирм", "controller"=>"catalog", "params"=>"catalog=CatalogFirmsCategory" ),
                    array( "title"=>"Категории ч. объявления", "controller"=>"catalog", "params"=>"catalog=CatalogItemsCategory" ),
                    array( "title"=>"Категории информации", "controller"=>"catalog", "params"=>"catalog=CatalogInfoCategory" ),
                    array( "title"=>"Категории курортов", "controller"=>"catalog", "params"=>"catalog=CatalogKurortsCategory" ),
                    array( "title"=>"Категории туров", "controller"=>"catalog", "params"=>"catalog=CatalogToursCategory" ),
                )
            )
        ),
        "titleName"=>"Туристический портал",

        /*
        * для кэширования виджетов, все что вам надо, это добавить массив с названием виджета, без прифекса _Widget
        * и указать параметры:
        * duration: Время жизни кэша
        * cacheID: ИД номер типа кэша
        * в данный момент доступны следующие ID:
        * CDummyCache - Пустышка, не производит кэширование данных (так же можно удалить массив с виджетом, тогда по дефолту ему выстовится CDummyCache)
        * CFileCache - Кэширование по средством файлов
        *
        * что бы добавить свой тип кэширования, необходимо в компоненты добавить следующую строчку:
        * 'CFileCache' => array('class' => 'CFileCache')  т.е. 'cacheID' => array('class' => 'ClassName'),
    */
        'widgetList' => array(
            'blocksnewswidget' => array(
                'duration' => 86400,
                'cacheID' => 'CFileCache',
            ),
            'menuwidget' => array(
                'duration' => 86400,
                'cacheID' => 'CFileCache',
            ),
            'fotoNewsWidget' => array(
                'duration' => 86400,
                'cacheID' => 'CFileCache',
            ),
        ),
    ),



    'controllerMap'=>array(
        'min'=>array(
            'class'=>'ext.minScript.controllers.ExtMinScriptController',
        ),
    ),

);