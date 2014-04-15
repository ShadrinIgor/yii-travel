<?php
return array(
    // У вас этот путь может отличаться. Можно подсмотреть в config/main.php.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cron',

    'preload'=>array('log'),

    'import'=>array(
        'application.models.*',
        'application.modules.subscribe.models.*',
        'application.components.*',
        'application.components.ImageHandler.CImageHandler',
        'application.components.CCApplicationComponent',
        'ext.favorites.models.*',
        'ext.banners.models.*',
    ),

    // Копирование yiic.php и console.php было сделано ради
    // перенаправления журнала для cron в отдельные файлы:
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),

        // Соединение с СУБД
        // uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=yii_travel',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1',
            'charset' => 'utf8',
        ),
    ),
);