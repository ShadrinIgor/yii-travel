<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("addsuser", "частные объявления")=>SiteHelper::createUrl("/adsUsers"),
        $item->category_id->name=>SiteHelper::createUrl("/adsUsers" )."/".$item->category_id->slug.".html",
        $item->name
    )
));
$images = ImageHelper::getImages( $item );
?>

<div id="InnerText">
    <br/>
    <?php SiteHelper::renderDinamicPartial( "pageDescriptionTop" ); ?>
    <h1><?= $item->name ?></h1>
    <div id="ITText" class="well">
        <div class="blockquote blockquoteOrange floatRight width200">
            <br/>
            <?= Yii::t("addsuser", "дата"); ?>: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
            <a href="<?= SiteHelper::createUrl("/adsUsers" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
            <?php if( $item->price > 0 ) : ?><?= Yii::t("addsuser", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/items/description", array( "id"=>$item->id )) ?>"><?= Yii::t("addsuser", "Редактировать"); ?></a><br/><?php endif; ?>
            <br/>
        </div>
        <?php if( sizeof($images) >0 || $item->image ) : ?>
            <div class="floatLeft leftImages">
                <?php if( $item->image ) : ?><a href="<?= $item->image ?>" title="<?= $item->name ?>" rel="lightbox"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" title="<?= $item->name ?>" alt="<?= $item->name ?>" /></a><?php endif; ?>
                <?php if( sizeof($images) >0 ) : ?>
                    <?php foreach( $images as $image ) : ?>
                        <a href="<?= $image->image ?>" title="<?= $item->name." ".$image->name ?>" rel="lightbox"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="well">
            <?= $item->description ?>
        </div>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($usersOther)>0 ) : ?>
        <h2><?= Yii::t("addsuser", "Другие объявления пользователя"); ?></h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $usersOther as $hotel ) : ?>
                <?php $this->widget("infoOneWidget", array( "item"=>$hotel, "link"=>"/adsUsers" )) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if( sizeof($otherHotels)>0 ) : ?>
        <h2><?= Yii::t("addsuser", "Другие объявления категории"); ?></h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherHotels as $hotel ) : ?>
                <?php $this->widget("infoOneWidget", array( "item"=>$hotel, "link"=>"/adsUsers" )) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


</div>