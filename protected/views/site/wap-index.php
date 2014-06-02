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
            <a href="<?= SiteHelper::createUrl("/Country") ?>" title="<?= Yii::t("page", "Туристические страны мира"); ?>"><?= Yii::t("page", "Туристические страны"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/tours") ?>" title="<?= Yii::t("page", "Туры"); ?>"><?= Yii::t("page", "Туры"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/hotels") ?>" title="<?= Yii::t("page", "Отели Узбекистана, мира"); ?>"><?= Yii::t("page", "Отели"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/resorts") ?>" title="<?= Yii::t("page", "Курорты, зоны отдыха, дет. лагеря"); ?>"><?= Yii::t("page", "Курорты, зоны отдыха, дет. лагеря"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/travelAgency") ?>" title="<?= Yii::t("page", "Туристические фирмы, агенства"); ?>"><?= Yii::t("page", "Туристические фирмы"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/adsUsers") ?>" title="<?= Yii::t("page", "Частные объявления"); ?>"><?= Yii::t("page", "Частные объявления"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/work") ?>" title="<?= Yii::t("page", "Работа в туризме"); ?>"><?= Yii::t("page", "Работа в туризме"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/touristInfo") ?>" title="<?= Yii::t("page", "Информация о туризме"); ?>"><?= Yii::t("page", "Информация о туризме"); ?></a>
        </div>
        <div class="WIItem" id="WICountry">
            <a href="<?= SiteHelper::createUrl("/news") ?>" title="<?= Yii::t("page", "Новости туризма"); ?>"><?= Yii::t("page", "Новости туризма"); ?></a>
        </div>
    </div>
    <br/>

<?php //$this->endCache();endif;