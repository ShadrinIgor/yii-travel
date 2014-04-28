<meta http-equiv="Cache-Control" content="public"/>
<meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ru" />
<title><?= Yii::app()->page->title; ?></title>
<meta name="Keywords" content="<?= Yii::app()->page->keyWord; ?>" />
<meta name="Description" content="<?= Yii::app()->page->description; ?>"/>

<link rel="icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" />

<base href="<?= SiteHelper::createUrl("/") ?>" />

<?php

    $cs=Yii::app()->clientScript;
    $cs->coreScriptPosition=CClientScript::POS_HEAD;
    $cs->scriptMap=array();
    $baseUrl=$Theme->getBaseUrl();

    $cs->registerScriptFile($baseUrl.'/js/jquery/jquery.js');

    if( Yii::app()->controller->module != '' || Yii::app()->controller->getId() != "default" )
        $cs->registerScriptFile($baseUrl.'/js/tiny_mce/tiny_mce.js');

    $cs->registerScriptFile($baseUrl.'/js/functions.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery/lightbox/jquery.lightbox.js');

    $cs->registerCssFile($baseUrl.'/css/style.css');
    $cs->registerCssFile($baseUrl.'/css/style2.css');
    if( defined("YII_SUBDOMAIN") && YII_SUBDOMAIN == "wap-" )
        $cs->registerCssFile($baseUrl.'/css/wap-style.css');

    $cs->registerCssFile($baseUrl.'/css/animation.css');

    $cs->registerCssFile($baseUrl.'/js/jquery/lightbox/jquery.lightbox.css');
    $this->getJsFiles( $cs );
    $this->getCssFiles( $cs );

?>

<?php
    //   $cs->registerCssFile($baseUrl.'/css/b_style.css');
?>
<style type="text/css">
    #TNet{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/t_bg.jpg ) no-repeat;width:958px;height:116px;margin:20px auto 10px;overflow:hidden; }
    #TLogo{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/t_logo.png ) no-repeat;width:144px;height:97px;float:left;margin:9px 20px 0 12px; }
    .TBan{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/baner_bg.png ) no-repeat;width:253px;height:112px;float:left;margin-top:1px }
    .TBan a{display:block;width:227px;height:97px;}

    .RB{margin: 0px 0 0 16px;  }
    .RBSmiles{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/smiles.uz.jpg) no-repeat; }
    .RBWorldTravel{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/world-travel.uz.jpg) no-repeat; }
    .RBWorldNews{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/world-news.uz.jpg) no-repeat; }
    .RBTrio{ background:url( <?=  $Theme->getBaseUrl() ?>/images/baners/trio.uz.jpg) no-repeat; }
</style>

<?php

if( Yii::app()->controller->module != '' || Yii::app()->controller->getId() != "default" ) :?>
    <script type="text/javascript">
        if( $("#ConsoleMain").length == 0 )
        {
            tinyMCE.init({
                // General options
                mode : "textareas",
                theme : "simple",
                plugins : "paste",

                // Theme options
                width: "100%",
                height: "300",
                paste_remove_styles: true,
                paste_remove_spans: true,
                paste_strip_class_attributes: 'all'
            });
        }
    </script>
<?php endif; ?>