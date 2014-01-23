<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ru" />
<title><?= Yii::app()->page->title; ?></title>

<link rel="icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" />

<base href="<?= SiteHelper::createUrl("/") ?>" />

<?php

    $cs=Yii::app()->clientScript;
    $cs->coreScriptPosition=CClientScript::POS_HEAD;
    $cs->scriptMap=array();
    $baseUrl=$Theme->getBaseUrl();
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile($baseUrl.'/js/tiny_mce/tiny_mce.js');
    $cs->registerScriptFile($baseUrl.'/js/functions.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery/lightbox/jquery.lightbox.js');

    $cs->registerCssFile($baseUrl.'/css/style.css');
    $cs->registerCssFile($baseUrl.'/css/style2.css');
    $cs->registerCssFile($baseUrl.'/css/b_style.css');
    $cs->registerCssFile($baseUrl.'/css/animation.css');

    $cs->registerCssFile($baseUrl.'/js/jquery/lightbox/jquery.lightbox.css');
    $this->getJsFiles( $cs );
    $this->getCssFiles( $cs );

?>

<meta http-equiv="Cache-Control" content="public"/>
<meta http-equiv="Cache-Control" content="max-age=3600, must-revalidate"/>

<meta name="Keywords" content="Отдых, туры,  туроператоры, путешествия, турция, анталия, узбекистан :: Туристический портал. :: Туристический портал" />
<meta name="Description" content="Отдых, туры,  туроператоры, путешествия, турция, анталия, узбекистан :: Туристический портал. :: Туристический портал"/>

<!--link href="<?=SiteHelper::createUrl("/") ?>images/jquery/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=SiteHelper::createUrl("/") ?>images/jquery/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=SiteHelper::createUrl("/") ?>images/jquery/jcarousellite.js"></script-->
