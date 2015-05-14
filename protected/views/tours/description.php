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
    <?php if( sizeof($images) >0 || $item->image ) : ?>
        <div class="widget">
            <div class="mid"><img src="<?= $images[0]->image ?>"></div>
            <div class="next"></div>
            <div class="prev"></div>
            <div class="carousel">
                <ul>
                <?php foreach( $images as $image ) : ?>
                    <li><a href="<?= $image->image ?>"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <div id="ITText">
        <div class="LParams">
            <?php if( $item->price ): ?><div class="tourPrice">от <b><?= $item->price ?> <?= $item->currency_id->title ?></b></div><?php endif; ?>
            <br/>
            <?= Yii::t("page", "страна"); ?>: <a href="<?= SiteHelper::createUrl("/country")."/".$item->slug ?>.html" title="<?= Yii::t("page", "туристическая страна"); ?> <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
            <?= Yii::t("page", "категория"); ?>:<a href="<?= SiteHelper::createUrl("/tours")."/".$item->category_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->category_id->name ) ?>"><?= $item->category_id->name ?></a><br/>
            <?= Yii::t("page", "фирма"); ?>а: <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
        </div>

        <?= $item->description ?>

        <?php if( $item->program ) : ?>
            <h3>Программа тура:</h3>
            <?= $item->program ?>
        <?php endif; ?>
        <?php if( $item->prices ) : ?>
            <h3>Описание цены:</h3>
            <?= $item->prices ?>
        <?php endif; ?>
        <?php if( $item->included ) : ?>
            <h3>В стоимость тура включенно:</h3>
            <?= $item->included ?>
        <?php endif; ?>
        <?php if( $item->not_included ) : ?>
            <h3>Не входид в стоимость тура:</h3>
            <?= $item->not_included ?>
        <?php endif; ?>
        <?php if( $item->attention ) : ?>
            <h3>Внимание:</h3>
            <?= $item->attention ?>
        <?php endif; ?>
        <?php if( $item->cancellation ) : ?>
            <h3>Условия анулирования:</h3>
            <?= $item->cancellation ?>
        <?php endif; ?>

        <div id="tourFirmInfo">
            <h2>Контакты для бронирования</h2>
            <b><?= Yii::t("page", "Тур предоставлен фирмой"); ?> <?= $item->firm_id->name ?></b><br/>
            <p><?= Yii::t("page", "Для бронирования или уточнения информации необходимо связаться с менеджером компании."); ?></p>
            <p>
                <?php if( $item->firm_id->tel ) : ?><b><?= Yii::t("page", "Телефон"); ?></b>: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?><b><?= Yii::t("page", "Факс"); ?></b>: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?><b>E-mail</b>: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"CatalogFirms", "id"=>$item->firm_id->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?><b><?= Yii::t("page", "Сайт"); ?></b>: <a target="_blank" href="<?= SiteHelper::checkWWW( $item->firm_id->www ) ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
            <div class="cMore">
                <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html"><?= Yii::t("page", "подробнее о фирме"); ?>...</a>
            </div>
            </p>
        </div>


    </div>
    <br/>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <br/><br/>
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