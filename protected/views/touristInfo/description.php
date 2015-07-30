<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "информация о туризме")=>SiteHelper::createUrl("/touristInfo"),
        $item->category_id->name=>SiteHelper::createUrl("/touristInfo", array( "category"=>$item->category_id->slug )).".html",
        $item->name
    )
));
?>

<div id="InnerText">
    <h1><?= $item->name ?></h1>
    <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <div id="ITText">
        <?php if( sizeof($images) >0 || $item->image ) : ?>
            <div class="floatLeft leftImages">
                <?php if( $item->image ) : ?><a href="<?= $item->image ?>" rel="lightbox[roadtrip]" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><?php endif; ?>
                <?php foreach( $images as $image ) : ?>
                    <a href="<?= $image->image ?>" title="<?= $item->name." ".$image->name ?>" rel="lightbox[roadtrip]"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="blockquote blockquoteOrange floatRight width200">
            <br/>
            <?php if( $item->country_id->id >0 ) : ?><?= Yii::t("page", "страна"); ?>: <a href="<?= SiteHelper::createUrl("/touristInfo", array("country"=>$item->country_id->slug)) ?>.html" title="<?= $item->country_id->name ?>"><?= $item->country_id->name ?></a><br/><?php endif; ?>
            <?php if( $item->category_id->id >0 ) : ?><?= Yii::t("page", "категория"); ?>:<a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item->category_id->slug)) ?>.html" title="<?= $item->category_id->name ?> - <?= Yii::t("page", "категория туристической информации"); ?>"><?= $item->category_id->name ?></a><br/><?php endif; ?>
            <br/>
        </div>
        <div class="well textAlignJustify">
            <?= $item->description ?>
        </div>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <br/>
    <?php $this->widget( "formNoteWidget", array( "type"=>"infoErrorNote" ) ); ?>

    <div class="hr">&nbsp;</div>

    <?php if( sizeof($tours)>0 ) : ?>
        <h2>Лучшие туры <?= $item->country_id->name_2 ?></h2>
        <div class="ITBlock">
            <?php foreach( $tours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->country_id->slug ?>.html" class="cmore" title="<?= Yii::t("page", "все туры"); ?> <?= $item->name_2 ?>"><?= Yii::t("page", "Смотреть все туры"); ?> <?= $item->country_id->name_2 ?> ( <?= !empty($tourCount) ? $tourCount : 0 ?> <?= Yii::t("page", "тура(ов)"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if( sizeof($other)>0 ) : ?>
        <h2><?= Yii::t("page", "Смотрите также"); ?></h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $other as $hotel ) : ?>
                <?php $this->widget("infoOneWidget", array( "item"=>$hotel )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item->category_id->slug)) ?>.html" class="cmore" title="<?= Yii::t("page", "информация"); ?> - <?= $item->category_id->name ?>"><?= Yii::t("page", "информация"); ?> - <?= $item->category_id->name ?> ( <?= $hotelCount ?> <?= Yii::t("page", "записи"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>

</div>