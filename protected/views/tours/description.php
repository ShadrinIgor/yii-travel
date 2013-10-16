<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "туры"=>SiteHelper::createUrl("tours/"),
        $item->country_id->name_2=>SiteHelper::createUrl("tours/index", array( "country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ) )),
        $item->name
    )
));
?>

<?php if( $this->beginCache( "country_".$item->id, array('duration'=>3600) ) ) : ?>
<div id="InnerText">
    <h1><?= $item->name ?></h1>
    <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <div id="ITText">
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="Туристическия странна <?= $item->name ?>" /></div><?php endif; ?>
        <div class="LParams">
            <br/>
            страна: <a href="<?= SiteHelper::createUrl("country/", array("id"=>$item->country_id->id)) ?>" title="туристическая страна <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
            категория:<a href="<?= SiteHelper::createUrl("tours/", array("category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item->category_id ))) ?>" title="<?= SiteHelper::getTranslateForUrl( $item->category_id->name ) ?>"><?= $item->category_id->name ?></a><br/>
            фирма: <a href="<?= SiteHelper::createUrl("firms/description", array("id"=>$item->firm_id->id, "slug"=>SiteHelper::getSlug( $item->firm_id ))) ?>" title="<?= SiteHelper::getTranslateForUrl( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a><br/>
            <br/>
            <a class="OrderRequest LPLink" href="#" title=Забронировать тур <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>">забронировать</a><br/>
        </div>
        <?= $item->description ?>
        <div id="orderInfo" class="displayNone">
            <b>Тур предоставлен фирмой <?= $item->firm_id->name ?></b><br/>
            <p>Для бронирования или уточнения информации по туру необходимо связатся с менеджером компании.</p>
            <p>
                <?php if( $item->firm_id->tel ) : ?>Телефон: <?= $item->firm_id->tel ?><br/><?php endif; ?>
                <?php if( $item->firm_id->fax ) : ?>Факс: <?= $item->firm_id->fax ?><br/><?php endif; ?>
                <?php if( $item->firm_id->email ) : ?>E-mail: <a href="mailto:<?= $item->firm_id->email ?>"><?= $item->firm_id->email ?></a><br/><?php endif; ?>
                <?php if( $item->firm_id->www ) : ?>Сайт: <a target="_blank" href="<?= $item->firm_id->www ?>"><?= $item->firm_id->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a> | <a href="<?= SiteHelper::createUrl("firms/description", array( "id"=>$item->firm_id->id, "slug"=>SiteHelper::getSlug( $item->firm_id ) )) ?>">подробнее о фирме...</a>
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
                <a href="<?= SiteHelper::createUrl("tours/", array("country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ))) ?>" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все туры <?= $item->name_2 ?> ( <?= $tourCount ?> тура(ов) )...</a>
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
                <a href="<?= SiteHelper::createUrl("firms/", array("country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ))) ?>" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все туры <?= $item->name_2 ?> ( <?= $tourCount ?> тура(ов) )...</a>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php $this->endCache(); endif;?>