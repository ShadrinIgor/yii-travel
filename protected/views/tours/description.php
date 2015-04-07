<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "туры")=>SiteHelper::createUrl("/tours"),
        $item->category_id->name=>SiteHelper::createUrl("/tours/category")."/".$item->category_id->slug.".html",
        $item->country_id->name_2=>SiteHelper::createUrl("/tours/country")."/".$item->country_id->slug.".html",
        $item->name
    )
));
?>

<div id="InnerText">
    <br/>
    <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <h1><?= $item->name ?><font>, тур <?= $item->category_id->name ?> <?= $item->country_id->name ?></font></h1>
    <div id="ITText">
        <div class="LParams">
            <br/>
            <?= Yii::t("page", "страна"); ?>: <a href="<?= SiteHelper::createUrl("/country")."/".$item->slug ?>.html" title="<?= Yii::t("page", "туристическая страна"); ?> <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
            <?= Yii::t("page", "категория"); ?>:<a href="<?= SiteHelper::createUrl("/tours")."/".$item->category_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->category_id->name ) ?>"><?= $item->category_id->name ?></a><br/>
            <?= Yii::t("page", "фирма"); ?>а: <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" onclick="ajaxLogTour( 'tours',<?= $item->id ?>, 'contact');yaCounter6154003.reachGoal('tour_show_contact');return true;" title="<?= Yii::t("page", "Забронировать тур"); ?> <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= Yii::t("page", "забронировать"); ?></a><br/>
        </div>
        <?php if( sizeof($images) >0 || $item->image ) : ?>
            <div class="floatLeft leftImages">
                <?php if( $item->image ) : ?><a href="<?= $item->image ?>" onclick="ajaxLogTour( 'tours',<?= $item->id ?>, 'showimage');" rel="lightbox[roadtrip]" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><?php endif; ?>
                <?php foreach( $images as $image ) : ?>
                    <a href="<?= $image->image ?>" title="<?= $item->name." ".$image->name ?>" onclick="ajaxLogTour( 'tours',<?= $item->id ?>, 'showimage');" rel="lightbox[roadtrip]"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?= $item->description ?>
        <div id="orderInfo" class="displayNone">
            <b><?= Yii::t("page", "Тур предоставлен фирмой"); ?> <?= $item->firm_id->name ?></b><br/>
            <p><?= Yii::t("page", "Для бронирования или уточнения информации необходимо связаться с менеджером компании."); ?></p>
            <p>
                <?php if( $item->firm_id->tel ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?><?= Yii::t("page", "Факс"); ?>: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"CatalogFirms", "id"=>$item->firm_id->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a target="_blank" href="<?= SiteHelper::checkWWW( $item->firm_id->www ) ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose"><?= Yii::t("page", "закрыть"); ?></a> | <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html"><?= Yii::t("page", "подробнее о фирме"); ?>...</a>
                </div>
            </p>
        </div>
        <div class="LParams">
            <br/>
            <a class="OrderRequest LPLink" href="#" onclick="ajaxLogTour( 'tours' ,<?= $item->id ?>, 'contact');yaCounter6154003.reachGoal('tour_show_contact');return true;" title="<?= Yii::t("page", "Забронировать тур"); ?> <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= Yii::t("page", "забронировать"); ?></a><br/>
        </div>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($otherTours)>0 ) : ?>
        <h2><?= Yii::t("page", "Похожие туры"); ?> <?= $item->country_id->name_2 ?></h2>
        <div class="ITBlock">
            <?php foreach( $otherTours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->country_id->slug ?>.html" class="cmore" title="<?= Yii::t("page", "все туры"); ?> <?= $item->name_2 ?>"><?= Yii::t("page", "Смотреть все туры"); ?> <?= $item->name_2 ?> ( <?= $tourCount ?> <?= Yii::t("page", "тура(ов)"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($firmsTours)>0 ) : ?>
        <h2><?= Yii::t("page", "Другие туры фирмы"); ?> <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsTours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html" class="cmore" title="<?= Yii::t("page", "все туры"); ?> <?= $item->name_2 ?>"><?= Yii::t("page", "Смотреть все туры"); ?> <?= $item->name_2 ?> ( <?= $tourCount ?> <?= Yii::t("page", "тура(ов)"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>

</div>