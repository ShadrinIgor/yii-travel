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
                '<language:(en)>'=>'site/index',

                '<language:(en)>/<controller:\w+>'=>'<controller>',
                '<language:(en)>/<controller:\w+>/sort/<sort:\w+>/by/<by:\w+>'=>'<controller>',

                '<language:(en)>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<language:(en)>/<controller:\w+>/<action:\w+>/<slug:[\w-]+>.html'=>'<controller>/<action>',
                '<language:(en)>/<controller:\w+>/<slug:[\w-]+>'=>'<controller>',
                '<language:(en)>/<controller:\w+>/<action:\w+>/<slug:[\w-]+>'=>'<controller>/<action>',
                '<language:(en)>/<module:\w+>/<controller:\w+>/<action:[\w-]+>/'=>'<controller>/<action>',
                '<language:(en)>/<module:\w+>/<controller:\w+>/<action:\w+>/<slug:[\w-]+>.html'=>'<controller>/<action>',

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

                '<language:(en)>/registration.html'=> 'user/default/Registration',
                'registration.html'=> 'user/default/Registration',
                'lost.html'=> 'user/default/lost',
                'logout.html'=> 'user/default/logout',

                '<slug:\w+>.html'=> 'page',
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

        'sitemapGenerator' => array(
            'class'         => 'ext.sitemap.SitemapGenerator',
            'path'          => dirname(dirname(dirname(__FILE__))).'/httpdocs/sitemap.xml',
            'sitemapUrl'    => 'http://flatora.ru/sitemap.xml',
            'pingGoogle'    => 'http://google.com/webmasters/sitemaps/ping?sitemap=',
            'pingYandex'    => 'http://webmaster.yandex.ru/wmconsole/sitemap_list.xml?host=',
            'pingYahoo'     => 'http://search.yahooapis.com/SiteExplorerService/V1/ping?sitemap=',
            'pingBing'      => 'http://www.bing.com/webmaster/ping.aspx?siteMap=',
            'pingAsk'       => 'http://submissions.ask.com/ping?sitemap='
        ),

        'assetManager'=>array(
            'basePath'=>realpath(dirname(dirname(dirname(__FILE__))).'/httpdocs/assets'),
        ),
        /*
         'messages'=>array(
             'class'            => 'PhpMessageSource',
         ),

         'messages'=>array(
             'class'            => 'DBCMessageSource',
             'forceTranslation' => true,
         ),*/

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
        "titleName"=> Yii::t( "models", "Туристический портал Узбекистана"),

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