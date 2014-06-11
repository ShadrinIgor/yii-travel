<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "зоны отдыха Узбекистана" )=>SiteHelper::createUrl("/resorts"),
        $item->category_id->name=>SiteHelper::createUrl("/resorts/category")."/".$item->category_id->slug.".html",
        $item->name
    )
));
$images = ImageHelper::getImages( $item );
?>

<div id="InnerText">
    <br/>
    <?php SiteHelper::renderDinamicPartial( "pageDescriptionTop" ); ?>
    <h1><?= $item->name ?> <font> - <?= $item->category_id->name." ".$item->country_id->name_2 ?></font></h1>
    <div id="ITText">
        <div class="LParams">
            <br/>
            <?php if( $item->price >0 ) : ?><b><?= $item->price ?>$</b><?php endif; ?>
            <?php if( $item->level && $item->level>0 ) : ?><?= SiteHelper::getStarsLevel( $item->level ) ?><br/><?php endif; ?>
            <?= Yii::t("page", "страна"); ?>: <?= $item->country_id->name ?><br/>
            <?php if( $item->city_id->id >0 ) : ?>город:<?= $item->city_id->name ?><br/><?php endif; ?>
            <br/>
            <a class="OrderRequest LPLink" href="#" title="<?= Yii::t("page", "Забронировать зону отдыха"); ?> <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= Yii::t("page", "забронировать"); ?></a><br/>
        </div>
        <?php if( sizeof($images) >0 || $item->image ) : ?>
            <div class="floatLeft leftImages">
                <?php if( $item->image ) : ?><a href="<?= $item->image ?>" rel="lightbox" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><?php endif; ?>
                <?php foreach( $images as $image ) : ?>
                    <a href="<?= $image->image ?>" title="<?= $item->name." ".$image->name ?>" rel="lightbox"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?= $item->description ?>
        <div class="LParams">
            <p><b><?= Yii::t("page", "Контактная информация"); ?>:</b><br/><br/>
                <?php if( $item->telefon ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail:<span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogKurorts", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                <?php if( $item->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                <br/><br/>
            </p>
            <a class="OrderRequest LPLink" href="#" title="<?= Yii::t("page", "Забронировать зону отдыха"); ?> <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= Yii::t("page", "забронировать"); ?></a>
        </div>
        <div id="orderInfo" class="displayNone">
            <b><?= Yii::t("page", "Курортная зона отдыха"); ?> - <?= $item->name ?></b><br/>
            <p><?= Yii::t("page", "Для бронирования или уточнения информации необходимо связаться с хозяином"); ?>.</p>
            <p>
                <?php if( $item->telefon ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail:<span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogKurorts", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                <?php if( $item->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose"><?= Yii::t("page", "закрыть"); ?></a>
                </div>
            </p>
        </div>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($otherHotels)>0 ) : ?>
        <h2><?= Yii::t("page", "Другие зоны отдыха"); ?> <?= $item->category_id->name ?></h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherHotels as $hotel ) : ?>
                <?php $this->widget("resortWidget", array( "item"=>$hotel )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item->category_id->slug ?>.html" class="cmore" title="<?= Yii::t("page", "все курорты"); ?> <?= $item->category_id->name ?>"><?= Yii::t("page", "Смотреть все курорты"); ?> - <?= $item->category_id->name ?> ( <?= $hotelCount ?> <?= Yii::t("page", "зон отдыха"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>
</div>