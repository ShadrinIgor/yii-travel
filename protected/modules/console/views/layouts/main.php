<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="ru" />
    <title><?= Yii::app()->page->title; ?></title>

    <link rel="icon" href="<?php echo $Theme->getBaseUrl() ?>/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $Theme->getBaseUrl() ?>/images/ico.ico" />

    <meta name="Keywords" content="" />
    <meta name="Description" content=""/>

    <?php

        $cs=Yii::app()->clientScript;
        $cs->coreScriptPosition=CClientScript::POS_HEAD;
        $cs->scriptMap=array();
        $baseUrl=$Theme->getBaseUrl();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl.'/js/functions.js');
        $cs->registerScriptFile($baseUrl.'/js/tiny_mce/tiny_mce.js');
        //$cs->registerScriptFile($baseUrl.'/js/lightbox/lightbox.js');

        $cs->registerCssFile($baseUrl.'/css/console-style.css');
        $this->getJsFiles( $cs );
        $this->getCssFiles( $cs );
    ?>

    <meta http-equiv="Cache-Control" content="public"/>
    <meta http-equiv="Cache-Control" content="max-age=3600, must-revalidate"/>

    <base href="<?= SiteHelper::createUrl("/")."console/" ?>" />

    <!-- TinyMCE -->
    <script type="text/javascript">

        tinyMCE.init({
            // General options
            mode : "textareas",
            theme : "advanced",
            plugins : "images,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

            // Theme options
            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,images,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,

            // Example word content CSS (should be your site CSS) this one removes paragraph margins
            content_css : "css/word.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",

            // Replace values for the template plugin
            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }
        });
    </script>
    <!-- /TinyMCE -->


</head>
<body>
    <div id="ConsoleMain">
        <?php $this->renderPartial( "console.views.layouts.menu" ) ?>
        <?php echo $content; ?>
    </div>
</body>