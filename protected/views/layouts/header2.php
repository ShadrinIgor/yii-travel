<meta http-equiv="Cache-Control" content="public"/>
<meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ru" />
<title><?= Yii::app()->page->title; ?></title>
<meta name="Keywords" content="<?= Yii::app()->page->keyWord; ?>" />
<meta name="Description" content="<?= Yii::app()->page->description; ?>"/>

<link rel="icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?= SiteHelper::createUrl("/", "", "&", true ) ?>" />

<?php

    $cs=Yii::app()->clientScript;
    $cs->coreScriptPosition=CClientScript::POS_HEAD;
    $cs->scriptMap=array();
    $baseUrl=$Theme->getBaseUrl();

    $cs->registerScriptFile($baseUrl.'/js/jquery/jquery.js');

    if( Yii::app()->controller->module != '' || Yii::app()->controller->getId() != "default" )
        $cs->registerScriptFile($baseUrl.'/js/tiny_mce/tiny_mce.js');

    $cs->registerScriptFile($baseUrl.'/js/functions2.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery/lightbox/jquery.lightbox.js');

    $cs->registerCssFile($baseUrl.'/css/style_new.css');
    $cs->registerCssFile($baseUrl.'/css/style_media.css');
    $cs->registerCssFile($baseUrl.'/js/jquery/lightbox/jquery.lightbox.css');
    $this->getJsFiles( $cs );
    $this->getCssFiles( $cs );
?>

<?php
    //   $cs->registerCssFile($baseUrl.'/css/b_style.css');
?>

<script type="text/javascript">
    var baseHref = '<?= SiteHelper::createUrl("/") ?>';
    var language = '<?= Yii::app()->getLanguage() ?>';
    <?php if( Yii::app()->controller->module != '' || Yii::app()->controller->getId() != "default" ) :?>
        if( $("#ConsoleMain").length == 0 )
        {
            tinyMCE.init({
                // General options
                mode : "textareas",
                theme : "simple",
                plugins : "paste",
                editor_deselector : "mceNoEditor",

                // Theme options
                width: "100%",
                height: "300",
                paste_remove_styles: true,
                paste_remove_spans: true,
                paste_strip_class_attributes: 'all'
            });
        }
    <?php endif; ?>
</script>

