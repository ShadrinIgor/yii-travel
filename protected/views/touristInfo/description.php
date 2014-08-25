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
        <div class="LParams">
            <br/>
            <?php if( $item->country_id->id >0 ) : ?><?= Yii::t("page", "страна"); ?>: <a href="<?= SiteHelper::createUrl("/touristInfo", array("country"=>$item->country_id->slug)) ?>.html" title="<?= $item->country_id->name ?>"><?= $item->country_id->name ?></a><br/><?php endif; ?>
            <?php if( $item->category_id->id >0 ) : ?><?= Yii::t("page", "категория"); ?>:<a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item->category_id->slug)) ?>.html" title="<?= $item->category_id->name ?> - <?= Yii::t("page", "категория туристической информации"); ?>"><?= $item->category_id->name ?></a><br/><?php endif; ?>
            <br/>
        </div>
        <?= $item->description ?>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"infoErrorNote" ) ); ?>

    <div class="hr">&nbsp;</div>

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