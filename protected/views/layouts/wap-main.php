<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $this->renderPartial('//layouts/header'); ?>
</head>

<?php
    Yii::app()->session["otherStyle"] = false;
    $mainClass = "";
    if( Yii::app()->controller->getId() != "site" )$mainClass = "MInnerPage";
    if( !Yii::app()->user->isGuest )
    {
        $userModel = CatalogUsers::fetch( Yii::app()->user->getId() );
        if( $userModel->desktop->id >0 && $userModel->desktop->class_name )
        {
            if( !empty( $mainClass ) )$mainClass.= " ";
            $mainClass .= "otherStyle ".$userModel->desktop->class_name;
            Yii::app()->session["otherStyle"] = true;
        }
    }
?>

<body>
<div id="Main" <?= !empty( $mainClass ) ? ' class="'.$mainClass.'"' : '' ?>>

<div id="BannerBlock">
    <br/>
    <Div id="BRight">
        <div id="BRTitle"><a href=""><img src="<?= $Theme->getBaseUrl() ?>/images/logo_title.png" /></a></div>
        <div id="BH1">
            <h1>Туристический портал, отдых, туры,  туроператоры, путешествия, турция, анталия, Узбекистан</h1>
        </div>
    </Div>
</div>

<div id="Center">

<div id="FCCentr">
    <?= $content; ?>
</div>

<div id="about_link">
    <div id="ALLinks">
        <a href="<?= SiteHelper::createUrl("/site/page")."/about" ?>" title="О проекте">О проекте</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="<?= SiteHelper::createUrl("/user/default/term")."/contact" ?>" title="Правила">Правила</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="<?= SiteHelper::createUrl("/site/page")."/contact" ?>" title="Контакты">Контакты</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <!--a href="" title="Реклама на сайте">Реклама на сайте</a> | -->
        <a href="<?= SiteHelper::createUrl("/site/page")."/besplatniy-reklamnyi-banner" ?>" title="Размещение бесплатного баннера">Бесплатный баннер</a><!-- |
    <a href="" title="Карта сайта">Карта ссылок</a>-->
    </div>
    <div id="counters">
        Возникла ошибка или есть вопросы, обращайтесь в нашу службу поддержки - <a href="mailto: <?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, мы обязательно Вам поможем.
        <br/><br/>
    </div>
    <div id="trioLogo">
        <?php SiteHelper::renderDinamicPartial( "counters" ) ?>
        <!--a href="http://www.trio.uz" title="Студия нового TRIO.uz!!!"><img src="<?= $Theme->getBaseUrl() ?>/images/trio.png" title="Студия нового TRIO.uz!!!"/></a-->
    </div>
</div>
</div>


</body>
</html>