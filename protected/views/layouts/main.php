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
    <div class="BottomLink">
        <?= Yii::t( "page", "<h3>детский лагерь</h3> <h4>отдых</h4> <b>туры</b> <u>туроператоры</u> <i>турфирмы</i> <i>горный лагерь</i> <font>турагентство</font> <u>зоны отдыха</u> <u>туристические агентства</u> <h3>тур фирмы</h3> <h4>туристические компании</h4> <b>поиск тура</b> <u>туроператоры</u> <h2>отдых в горах</h2> <b>тур фирмы</b>" ) ?>
    </div>
        <div id="BBLeft">
            <?php if( !Yii::app()->session["otherStyle"] ) : ?>
                <img src="<?= $Theme->getBaseUrl() ?>/images/logo.jpg" alt="<?= Yii::t( "page", "мировой отдых для вас, туристический портал") ?>" />
            <?php endif; ?>
        </div>
    <Div id="BRight">
        <div id="BRTitle"><a href=""><img src="<?= $Theme->getBaseUrl() ?>/images/logo_title_<?= Yii::app()->getLanguage() ?>.png" /></a></div>
        <?php if( Yii::app()->controller->getId() == "site" ) : ?><div id="BRHref"><a href=""><b>W</b>orld-<b>T</b>ravel.<font>uz</font></a></div><?php endif; ?>
        <?php if( Yii::app()->controller->getId() != "site" ) : ?><div id="BMedal"><div id="TMedal"></div><div id="TrioMedal"></div></div><?php endif; ?>
        <div id="BH1">
            <h1><?= Yii::t( "page", "Туристический портал, отдых, туры,  туроператоры, путешествия, турция, анталия, Узбекистан") ?></h1>
        </div>
    </Div>
    <div id="Menu1">
        <div id="Menu" class="lang_<?= Yii::app()->getLanguage() ?>">
        <div class="CItem MFirst">
            <a href="<?= SiteHelper::createUrl( "/sales" ) ?>" title="<?= Yii::t( "page", "туристические акции, скидки, горячие предложения") ?>" class="MenuJsClass" id="c6"></a>
            <div class="CHint" id="bh8">
                <div class="CHText">
                    <div><?= Yii::t( "page", "Новости") ?></div>
                </div>
            </div>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/Country/" ) ?>" title="<?= Yii::t( "page", "Туристические странны") ?>" class="MenuJsClass" id="c1"></a>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/tours/" ) ?>" title="<?= Yii::t( "page", "Туры") ?>" class="MenuJsClass" id="c2"></a>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/hotels/" ) ?>" title="<?= Yii::t( "page", "Отели") ?>" class="MenuJsClass" id="c3"></a>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/resorts/" ) ?>" title="<?= Yii::t( "page", "Курорты зоны отдыха, детские лагеря") ?>" class="MenuJsClass" id="c4"></a>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/touristInfo" ) ?>" title="<?= Yii::t( "page", "информация для туристов") ?>" class="MenuJsClass" id="c5"></a>
        </div>

        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/travelAgency" ) ?>" title="<?= Yii::t( "page", "туристические агенства, тур фирмы") ?>" class="MenuJsClass" id="c7"></a>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/adsUsers " ) ?>" title="<?= Yii::t( "page", "туристические частные объявления") ?>" class="MenuJsClass" id="c9"></a>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "/work" ) ?>" title="<?= Yii::t( "page", "Работа") ?>" class="MenuJsClass" id="c8"></a>
        </div>
    </div>
    </div>
</div>

<div id="Center">

<div id="Left">
    <?= SiteHelper::renderDinamicPartial("leftColumn") ?>
</div>
<?= SiteHelper::renderDinamicPartial("rightColumn") ?>
<div id="FCCentr">
    <?php TrainingsHelper::show(); ?>
    <?= Yii::app()->banners->getBannerByCategory( "top" ) ?>
    <?= Yii::app()->notifications->getList() ?>
    <?= SiteHelper::renderDinamicPartial("topSection") ?>
    <?= $content; ?>
</div>

<script language="JavaScript" type="text/javascript">
    MenuActions("Center");
</script>


<div id="about_link">
    <div id="ALLinks">
        <a href="<?= SiteHelper::createUrl("/site/page")."/about" ?>" title="<?= Yii::t( "page", "О проекте") ?>"><?= Yii::t( "page", "О проекте") ?></a> |
        <a href="<?= SiteHelper::createUrl("/user/default/term")."/contact" ?>" title="<?= Yii::t( "page", "Правила") ?>"><?= Yii::t( "page", "Правила") ?></a> |
        <a href="<?= SiteHelper::createUrl("/site/page")."/contact" ?>" title="<?= Yii::t( "page", "Контакты") ?>"><?= Yii::t( "page", "Контакты") ?></a> |
        <!--a href="" title="Реклама на сайте">Реклама на сайте</a> | -->
        <a href="<?= SiteHelper::createUrl("/site/page")."/besplatniy-reklamnyi-banner" ?>" title="<?= Yii::t( "page", "Размещение бесплатного баннера") ?>"><?= Yii::t( "page", "Бесплатный баннер") ?></a>
        <!-- |
    <a href="" title="Карта сайта">Карта ссылок</a>-->
    </div>
    <div id="counters">
        <?= Yii::t( "page", "Возникла ошибка или есть вопросы, обращайтесь в нашу службу поддержки") ?> - <a href="mailto: <?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, <?= Yii::t( "page", "мы обязательно Вам поможем.") ?>
        <br/><br/>
    </div>
    <div id="trioLogo">
        <?php /*if( $this->beginCache( "counters_block", array('duration'=>3600) ) ) :*/ ?>
        <?php SiteHelper::renderDinamicPartial( "counters" ) ?>
        <?php
              /*$this->endCache();
              endif;*/
        ?>
        <!--a href="http://www.trio.uz" title="Студия нового TRIO.uz!!!"><img src="<?= $Theme->getBaseUrl() ?>/images/trio.png" title="Студия нового TRIO.uz!!!"/></a-->
    </div>
</div>
<div class="BottomLink">
    <?= Yii::t( "page", "<h3>детский лагерь</h3> <h4>отдых</h4> <b>туры</b> <u>туроператоры</u> <i>турфирмы</i> <i>горный лагерь</i> <font>турагентство</font> <u>зоны отдыха</u> <u>туристические агентства</u> <h3>тур фирмы</h3> <h4>туристические компании</h4> <b>поиск тура</b> <u>туроператоры</u> <h2>отдых в горах</h2> <b>тур фирмы</b>" ) ?></div>
</div>

<!--div id="TNet">
    <div id="TLogo"></div>
    <div class="TBan"><div class="RB RBSmiles"><a href="http://www.smiles.uz" title="Юмористические портал смешные новости, фото и видео приколы, карикатуры, демотиваторы :: Юмористические портал - Smilesт"></a></div></div>
    <div class="TBan"><div class="RB RBWorldNews"><a href="http://www.world-news.uz" title="Мировые новости, политика, финансы, экономика, спорт"></a></div></div>
    <div class="TBan"><div class="RB RBTrio"><a href="http://www.trio.uz" title="Студия нового"></a></div></div>
</div-->
</body>
</html>