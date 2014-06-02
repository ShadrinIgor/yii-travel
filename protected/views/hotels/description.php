<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "Все отели")=>SiteHelper::createUrl("/hotels"),
        Yii::t("page", "отели").$item->country_id->name_2=>SiteHelper::createUrl("/hotels/country" )."/".$item->country_id->slug.".html",
        $item->name
    )
));
$images = ImageHelper::getImages( $item );
?>

<div id="InnerText">
    <br/>
    <?php SiteHelper::renderDinamicPartial( "pageDescriptionTop" ); ?>
    <h1><?= $item->name ?></h1>
    <div id="ITText">
        <div class="LParams">
            <br/>
            <?php if( $item->level && $item->level>0 ) : ?><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" /><br/><?php endif; ?>
            <?= Yii::t("page", "страна"); ?>: <a href="<?= SiteHelper::createUrl("/hotels/country/")."/".$item->country_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
            <?= Yii::t("page", "город"); ?>:<a href="<?= SiteHelper::createUrl("/hotels/city/")."/".$item->city_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->city_id->name ) ?>"><?= $item->city_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" title="<?= Yii::t("page", "Забронировать отель"); ?> <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= Yii::t("page", "забронировать"); ?></a><br/>
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
            <p><b><?= Yii::t("page", "Контактая информация"); ?>:</b><br/><br/>
                <?php if( $item->tel ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->fax ) : ?><?= Yii::t("page", "Факс"); ?>: <?= $item->fax ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogHotels", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                <?php if( $item->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                <?php if( $item->address ) : ?><?= $item->address ?><?php endif; ?>
                <br/><br/>
            </p>
            <a class="OrderRequest LPLink" href="#" title="<?= Yii::t("page", "Забронировать отель"); ?> <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>"><?= Yii::t("page", "забронировать"); ?></a>
        </div>
        <div id="orderInfo" class="displayNone">
            <b><?= Yii::t("page", "отель"); ?> - <?= $item->name ?></b><br/>
            <p><?= Yii::t("page", "Для бронирования или уточнения информации по отелю необходимо связаться с менеджером компании."); ?></p>
            <p>
                <?php if( $item->tel ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->fax ) : ?><?= Yii::t("page", "Факс"); ?>: <?= $item->fax ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogHotels", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
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
        <h2><?= Yii::t("page", "Другие отели"); ?> <?= $item->country_id->name_2 ?>,<?= $item->city_id->name ?></h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherHotels as $hotel ) : ?>
                <?php $this->widget("hotelWidget", array( "item"=>$hotel )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/hotels/country")."/".$item->slug ?>.html" class="cmore" title="<?= Yii::t("page", "все отели"); ?> <?= $item->country_id->name_2 ?>"><?= Yii::t("page", "Смотреть все отели"); ?> <?= $item->country_id->name_2 ?> ( <?= $hotelCount ?> <?= Yii::t("page", "отелей(я)"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>
</div>