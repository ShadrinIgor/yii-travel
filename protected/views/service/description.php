<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "туристические фирмы"=>SiteHelper::createUrl("/travelAgency"),
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
    <h1><?= $item->name ?><font>, услуга от копании <?= $item->firm_id->name ?>, <?= $item->firm_id->country_id->name ?></font></h1>
    <div id="ITText">
        <div class="LParams">
            <br/>
            фирма: <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" title=Связатся с компанией <?= $item->firm_id->name ?>">Связатся с компанией</a><br/>
        </div>
        <?php if( sizeof($images) >0 ) : ?>
            <div class="floatLeft leftImages">
                <?php foreach( $images as $image ) : ?>
                    <a href="<?= $image->image ?>" title="<?= $item->name." ".$image->name ?>" rel="lightbox"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?= $item->description ?>
        <div id="orderInfo" class="displayNone">
            <b>Тур предоставлен фирмой <?= $item->firm_id->name ?></b><br/>
            <p>Для бронирования или уточнения информации необходимо связаться с менеджером компании.</p>
            <p>
                <?php if( $item->firm_id->tel ) : ?>Телефон: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?>Факс: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogFirms", "id"=>$item->firm_id->id, "field"=>"email" ) ) ?>' ); return false;">[ Показать Email ]</a></span><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?>Сайт: <a target="_blank" href="<?= $item->firm_id->www ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a> | <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html">подробнее о фирме...</a>
                </div>
            </p>
        </div>

    </div>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($firmsService)>0 ) : ?>
        <h2>Другие туристические услуги агенства <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsService as $tour ) : ?>
                <?php $this->widget("itemWidget", array( "link"=>"service", "item"=>$tour )) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if( sizeof($firmsItems)>0 ) : ?>
        <h2>Акции туристического агентства <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsItems as $tour ) : ?>
                <?php $this->widget("itemWidget", array( "link"=>"item", "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html" class="cmore" title="все акции/скидки <?= $item->firm_id->name ?>">все акции/скидки <?= $item->firm_id->name ?></a>
            </div>
        </div>
    <?php endif; ?>
</div>