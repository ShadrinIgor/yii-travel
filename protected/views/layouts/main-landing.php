<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $this->renderPartial('//layouts/header2'); ?>
</head>
<body>
<div id="Main">
<div class="Header HInner">
    <div id="HTitle2"><a href="" title="">Туристический портал Узбекистана</a></div>
    <div id="HTitle">
        <div id="HRight" class="HRT">
            все туристичекие фирмы в одной
        </div>
    </div>
    <div id="HLogin">
        <a href="" title="">Зарегестироваться</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" title="">Войти</a>
    </div>
</div>
<div>
    <div class="TMenuSmall displayNone"><a href="#" title="">Меню сайта</a></div>
    <div class="TMenu">
        <a href="<?= SiteHelper::createUrl( "/Country" ) ?>" title="<?= Yii::t( "page", "Туристические странны") ?>">Страны</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/sales" ) ?>" title="<?= Yii::t( "page", "туристические акции, скидки, горячие предложения") ?>">Акции</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/tours" ) ?>" title="<?= Yii::t( "page", "Туры") ?>">Туры</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/resorts" ) ?>" title="<?= Yii::t( "page", "Отели") ?>">Отели</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/touristInfo" ) ?>" title="<?= Yii::t( "page", "информация для туристов") ?>">О туризме</a>
        <a href="<?= SiteHelper::createUrl( "/travelAgency " ) ?>" title="<?= Yii::t( "page", "туристические агенства, тур фирмы") ?>">Тур. фирмы</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/hotels" ) ?>" title="<?= Yii::t( "page", "Отели") ?>">Отели</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/work" ) ?>" title="<?= Yii::t( "page", "Работа") ?>">Вакансии</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/adsUsers " ) ?>" title="<?= Yii::t( "page", "туристические частные объявления") ?>">Частные объявления</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/user" ) ?>" title="">Кабинет</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
    </div>
</div>

    <?= $content; ?>

    <div id="Footer">
    <div id="FMenu">
        <a href="<?= SiteHelper::createUrl( "/Country" ) ?>" title="<?= Yii::t( "page", "Туристические странны") ?>">Страны</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/sales" ) ?>" title="<?= Yii::t( "page", "туристические акции, скидки, горячие предложения") ?>">Акции</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/tours" ) ?>" title="<?= Yii::t( "page", "Туры") ?>">Туры</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/resorts" ) ?>" title="<?= Yii::t( "page", "Отели") ?>">Отели</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/touristInfo" ) ?>" title="<?= Yii::t( "page", "информация для туристов") ?>">О туризме</a>
        <a href="<?= SiteHelper::createUrl( "/travelAgency " ) ?>" title="<?= Yii::t( "page", "туристические агенства, тур фирмы") ?>">Тур. фирмы</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/hotels" ) ?>" title="<?= Yii::t( "page", "Отели") ?>">Отели</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/work" ) ?>" title="<?= Yii::t( "page", "Работа") ?>">Вакансии</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/adsUsers " ) ?>" title="<?= Yii::t( "page", "туристические частные объявления") ?>">Частные объявления</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href="<?= SiteHelper::createUrl( "/user" ) ?>" title="">Кабинет</a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
    </div>

    <div id="FText">
        Возникла ошибка или есть вопросы? Обращайтесь в нашу службу поддержки - <a href="mailto:support@world-travel.uz">support@world-travel.uz</a>, мы обязательно Вам поможем.
    </div>
</div>
</div>

    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function(){ var widget_id = 'FrS4Yvbmmg';
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();
    <!-- {/literal} END JIVOSITE CODE -->
    </script>
</body>
</html>