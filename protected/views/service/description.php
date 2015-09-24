<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "Туристические фирмы, агенства")=>SiteHelper::createUrl("/travelAgency"),
        $item->firm_id->name=>SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug.".html",
        $item->name
    )
));
?>

<div id="InnerText">
    <br/>
    <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <h1><?= $item->name ?><font>, <?= Yii::t("page", "услуга от компании"); ?> <?= $item->firm_id->name ?>, <?= $item->firm_id->country_id->name ?></font></h1>
    <div id="ITText">
        <div class="LParams">
            <br/>
            <?= Yii::t("page", "фирма"); ?>: <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" title="<?= Yii::t("page", "Связаться с компанией") ?> <?= $item->firm_id->name ?>"><?= Yii::t("page", "Связаться с компанией"); ?></a><br/>
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
        <div id="orderInfo" class="displayNone">
            <b><?= Yii::t("page", "Услуга предоставлена фирмой"); ?> <?= $item->firm_id->name ?></b><br/>
            <p><?= Yii::t("page", "Для бронирования или уточнения информации необходимо связаться с менеджером компании"); ?>.</p>
            <p>
                <?php if( $item->firm_id->tel ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?><?= Yii::t("page", "Факс"); ?>: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"CatalogFirms", "id"=>$item->firm_id->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a target="_blank" href="<?= $item->firm_id->www ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose"><?= Yii::t("page", "закрыть"); ?></a> | <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html"><?= Yii::t("page", "подробнее о фирме"); ?>...</a>
                </div>
            </p>
        </div>

    </div>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($firmsService)>0 ) : ?>
        <h2><?= Yii::t("page", "Другие туристические услуги агенства"); ?> <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsService as $tour ) : ?>
                <?php $this->widget("itemWidget", array( "link"=>"service", "item"=>$tour )) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if( sizeof($firmsItems)>0 ) : ?>
        <h2><?= Yii::t("page", "Акции туристического агенства"); ?> <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsItems as $tour ) : ?>
                <?php $this->widget("itemWidget", array( "link"=>"item", "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" class="cmore" title="<?= Yii::t("page", "все акции/скидки"); ?> <?= $item->firm_id->name ?>"><?= Yii::t("page", "все акции/скидки"); ?> <?= $item->firm_id->name ?></a>
            </div>
        </div>
    <?php endif; ?>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
</div>