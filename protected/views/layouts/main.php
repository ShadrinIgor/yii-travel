<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $this->renderPartial('//layouts/header'); ?>
</head>

<body>
<div id="Main" <?= ( Yii::app()->controller->getId() != "site" ) ? ' class="MInnerPage"' : '' ?>>


<div id="BannerBlock">
    <div class="BottomLink">
        <h3>детский лагерь</h3> <h4>отдых</h4> <b>туры</b> <u>туроператоры</u> <i>турфирмы</i> <i>горный лагерь</i> <font>турагентство</font> <u>зоны отдыха</u> <u>туристические агентства</u> <h3>тур фирмы</h3> <h4>туристические компании</h4> <b>поиск тура</b> <u>туроператоры</u> <h2>отдых в горах</h2> <b>тур фирмы</b>
    </div>
    <div id="BBLeft"><img src="<?= $Theme->getBaseUrl() ?>/images/logo.jpg" alt="мировой отдых для вас, туристический портал" /></div>
    <Div id="BRight">
        <div id="BRTitle"><a href=""><img src="<?= $Theme->getBaseUrl() ?>/images/logo_title.png" /></a></div>
        <?php if( Yii::app()->controller->getId() == "site" ) : ?><div id="BRHref"><a href=""><b>W</b>orld-<b>T</b>ravel.<font>uz</font></a></div><?php endif; ?>
        <?php if( Yii::app()->controller->getId() != "site" ) : ?><div id="BMedal"><div id="TMedal"><a href=""></a></div><div id="TrioMedal"><a href=""></a></div></div><?php endif; ?>
        <div id="BH1">
            <h1>Туристический портал, отдых, туры,  туроператоры, путешествия, турция, анталия, узбекистан</h1>
        </div>
    </Div>
    <div id="Menu">
        <div class="CItem MFirst">
            <a href="<?= SiteHelper::createUrl( "Country/" ) ?>" title="Туристические странны" class="MenuJsClass" id="h2">
                <img src="f/catalog_menu/801center1.jpg" alt="Странны" /></a>
            <div class="CHint" id="bh2">
                <div class="CHText">
                    <div>Странны</div>
                    Список стран, с описанием страны - туры страны, курорты страны, отели страны, тур. фирмы страны, частные объявления, о туризме в стране, туристические акции, галлерея .
                </div>
            </div>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "tours/" ) ?>" title="Туры" class="MenuJsClass" id="h10">
                <img src="f/catalog_menu/547tours.jpg" alt="Туры" /></a>
            <div class="CHint" id="bh10">
                <div class="CHText">
                    <div>Туры</div>
                    <br/>
                    Список туров от различных компаний, разделенных по категориям и странам.
                </div>
            </div>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "hotels/" ) ?>" title="Отели" class="MenuJsClass" id="h9">
                <img src="f/catalog_menu/514hotels.jpg" alt="Отели" /></a>
            <div class="CHint" id="bh9">
                <div class="CHText">
                    <div>Отели</div>
                    <br/>
                    Список отелей различных стран, разделенных по рейтингу и странам.
                </div>
            </div>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "resorts/" ) ?>" title="Курорты" class="MenuJsClass" id="h3">
                <img src="f/catalog_menu/821center2.jpg" alt="Курорты" /></a>
            <div class="CHint" id="bh3">
                <div class="CHText">
                    <div>Курорты</div>
                    <br/>
                    Список курортов различных стран, разделенных по категориям и странам.
                </div>
            </div>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "info/" ) ?>" title="О туризме" class="MenuJsClass" id="h4">
                <img src="f/catalog_menu/21center3.jpg" alt="О туризме" /></a>
            <div class="CHint" id="bh4">
                <div class="CHText">
                    <div>О туризме</div>

                    <br/>
                    Информация о туризме, статьи о городах, особенности туризма.

                </div>
            </div>
        </div>
        <div class="CItem">
            <a href="<?= SiteHelper::createUrl( "firms/" ) ?>" title="Фирмы" class="MenuJsClass" id="h8">
                <img src="f/catalog_menu/964travel.jpg" alt="Фирмы" /></a>
            <div class="CHint" id="bh8">
                <div class="CHText">
                    <div>Фирмы</div>

                    <br/>
                    Туристические компании, разделенные странам.

                </div>
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
    <?= SiteHelper::renderDinamicPartial("topSection") ?>
    <?= $content; ?>
</div>

<script language="JavaScript" type="text/javascript">
    MenuActions("Center");
</script>


<div id="about_link">
    <div id="trioLogo"><a href="http://www.trio.uz" title="Студия нового TRIO.uz!!!"><img src="<?= $Theme->getBaseUrl() ?>/images/trio.png" title="Студия нового TRIO.uz!!!"</a></div>

    <div id="counters">


    </div>

    <div id="ALLinks">
        <a href="project/" title="О проекте">О проекте</a> |
        <a href="contact/" title="Контакты">Контакты</a> |
        <!--a href="" title="Реклама на сайте">Реклама на сайте</a> | -->
        <a href="map/" title="Карта сайта">Карта сайта</a><!-- |
    <a href="" title="Карта сайта">Карта ссылок</a>-->
    </div>
</div>
<div class="BottomLink">
    <h3>детский лагерь</h3> <b>туры</b> <h3>турция</h3> <u>туроператоры</u> <i>турфирмы</i> <i>туры в турцию</i> <font>турагентство</font> <i>горный лагерь</i> <u>туристические агентства</u> <h3>тур фирмы</h3> <h4>туристические компании</h4> <u>зоны отдыха</u> <u>туроператоры</u> <h2>отдых в горах</h2> <b>тур фирмы</b>
</div>
</div>

<div id="TNet">
    <div id="TLogo"></div>
    <div class="TBan"><div class="RB RBSmiles"><a href="http://www.smiles.uz" title="Юмористические портал смешные новости, фото и видео приколы, карикатуры, демотиваторы :: Юмористические портал - Smilesт"></a></div></div>
    <div class="TBan"><div class="RB RBWorldNews"><a href="http://www.world-news.uz" title="Мировые новости, политика, финансы, экономика, спорт"></a></div></div>
    <div class="TBan"><div class="RB RBTrio"><a href="http://www.trio.uz" title="Студия нового"></a></div></div>
</div>
</body>
</html>