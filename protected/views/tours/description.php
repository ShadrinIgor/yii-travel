<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "туры"=>SiteHelper::createUrl("/tours"),
        $item->category_id->name=>SiteHelper::createUrl("/tours/category")."/".$item->category_id->slug,
        $item->country_id->name_2=>SiteHelper::createUrl("/tours/country")."/".$item->country_id->slug,
        $item->name
    )
));
?>

<div id="InnerText">
    <h1><?= $item->name ?><font>, тур <?= $item->category_id->name ?>, <?= $item->country_id->name ?></font></h1>
    <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <div id="ITText">
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="Туристическия странна <?= $item->name ?>" /></div><?php endif; ?>
        <div class="LParams">
            <br/>
            страна: <a href="<?= SiteHelper::createUrl("/country")."/".$item->slug ?>" title="туристическая страна <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
            категория:<a href="<?= SiteHelper::createUrl("/tours")."/".$item->category_id->slug ?>" title="<?= SiteHelper::getStringForTitle( $item->category_id->name ) ?>"><?= $item->category_id->name ?></a><br/>
            фирма: <a href="<?= SiteHelper::createUrl("/firms/description")."/".$item->firm_id->slug ?>" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" title=Забронировать тур <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>">забронировать</a><br/>
        </div>
        <?= $item->description ?>
        <div id="orderInfo" class="displayNone">
            <b>Тур предоставлен фирмой <?= $item->firm_id->name ?></b><br/>
            <p>Для бронирования или уточнения информации по туру необходимо связаться с менеджером компании.</p>
            <p>
                <?php if( $item->firm_id->tel ) : ?>Телефон: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?>Факс: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogFirms", "id"=>$item->firm_id->id, "field"=>"email" ) ) ?>' ); return false;">[ Показать Email ]</a></span><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?>Сайт: <a target="_blank" href="<?= $item->firm_id->www ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a> | <a href="<?= SiteHelper::createUrl("/firms/description")."/".$item->firm_id->slug ?>">подробнее о фирме...</a>
                </div>
            </p>
        </div>
        <div class="LParams">
            <br/>
            <a class="OrderRequest LPLink" href="#" title=Забронировать тур <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>">забронировать</a><br/>
        </div>
    </div>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($otherTours)>0 ) : ?>
        <h2>Похошие туры <?= $item->country_id->name_2 ?></h2>
        <div class="ITBlock">
            <?php foreach( $otherTours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->country_id->slug ?>" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все туры <?= $item->name_2 ?> ( <?= $tourCount ?> тура(ов) )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($firmsTours)>0 ) : ?>
        <h2>Тругие туры фирмы <?= $item->firm_id->name ?></h2>
        <div class="ITBlock">
            <?php foreach( $firmsTours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/firms")."/".$item->slug ?>" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все туры <?= $item->name_2 ?> ( <?= $tourCount ?> тура(ов) )...</a>
            </div>
        </div>
    <?php endif; ?>

</div>