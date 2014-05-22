<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=yii-news',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'info@world-travel.uz',
        'supportEmail'=>'support@world-travel.uz',
        'baseUrl' => 'http://yii-travel.loc/',
        'images' => array(),
        'images_quality'=>70, // Работает только для JPG
        "catalogList"=>array(),
        "titleName"=>"Туристический портал",
        'mail-server' => 'world-travel.uz',
        'mail-host' => 'world-travel.uz',
        'mail-log' => 'info@world-travel.uz',
        'mail-pass' => '15e2oYUn',
    ),
);