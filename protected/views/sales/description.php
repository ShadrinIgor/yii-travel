<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "акции, скидки"=>SiteHelper::createUrl("/sales"),
        $item->name
    )
));
?>

<div id="InnerText">
    <br/>
    <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <h1><?= $item->name ?><font>, акция компании <?= $item->firm_id->name ?></font></h1>
    <div id="ITText">
        <div class="LParams">
            <br/>
            фирма: <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" title=Забронировать акцию <?= SiteHelper::getStringForTitle( $item->name ) ?>">забронировать</a><br/>
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
            <b>Акция предоставлена фирмой <?= $item->firm_id->name ?></b><br/>
            <p>Для уточнения информации необходимо связаться с менеджером компании.</p>
            <p>
                <?php if( $item->firm_id->tel ) : ?>Телефон: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?>Факс: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"CatalogFirms", "id"=>$item->firm_id->id, "field"=>"email" ) ) ?>' ); return false;">[ Показать Email ]</a></span><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?>Сайт: <a target="_blank" href="<?= SiteHelper::checkWWW( $item->firm_id->www ) ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a> | <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html">подробнее о фирме...</a>
                </div>
            </p>
        </div>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($firmsTours)>0 ) : ?>
        <h2>Другие акции фирмы <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsTours as $tour ) : ?>
                <?php $this->widget("infoOneWidget", array( "item"=>$tour, "link"=>"sales" )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html" class="cmore" title="все акции <?= $item->firm_id->name ?>">Смотреть все акции <?= $item->firm_id->name ?> ( <?= $firmCount ?> акций) )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($otherTours)>0 ) : ?>
        <h2>Похошие акции</h2>
        <div class="ITBlock">
            <?php foreach( $otherTours as $tour ) : ?>
                <?php $this->widget("infoOneWidget", array( "item"=>$tour, "link"=>"sales" )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/sales")."/" ?>" class="cmore" title="все акции ">Смотреть все акции</a>
            </div>
        </div>
    <?php endif; ?>


</div>