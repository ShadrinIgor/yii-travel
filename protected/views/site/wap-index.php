<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

//if( $this->beginCache( "wap-firstPage", array('duration'=>3600) ) ) :
?>
    <div id="Buttons">
        <?php $this->widget("topButtonWidget", array( "type"=>"add_first" )) ?>
    </div>
    <br/>
    <div class="WIndexMenu">
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/Country") ?>" title="Туристические страны мира">Туристические страны</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/tours") ?>" title="Туры">Туры</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/hotels") ?>" title="Отели Узбекистана, мира">Отели</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/resorts") ?>" title="Курорты, зоны отдыха, дет. лагеря">Курорты, зоны отдыха, дет. лагеря</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/travelAgency") ?>" title="Туристические фирмы, агенства">Туристические фирмы</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/adsUsers") ?>" title="Частные объявления">Частные объявления</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/work") ?>" title=Работа в туризме">Работа в туризме</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/touristInfo") ?>" title="Информация о туризме">Информация о туризме</a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/news") ?>" title="Новости туризма">Новости туризма</a>
        </div>
    </div>
    <br/>

<?php //$this->endCache();endif;