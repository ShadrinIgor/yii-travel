<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "куротные зоны"=>SiteHelper::createUrl("resorts/"),
        $item->category_id->name=>SiteHelper::createUrl("resorts/index", array( "category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item->category_id ) )),
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
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="отелиистическия странна <?= $item->name ?>" /></div><?php endif; ?>
        <div class="LParams">
            <br/>
            <?php if( $item->price >0 ) : ?><b><?= $item->price ?>$</b><?php endif; ?>
            <?php if( $item->level && $item->level>0 ) : ?><?= SiteHelper::getStarsLevel( $item->level ) ?><br/><?php endif; ?>
            страна: <a href="<?= SiteHelper::createUrl("country/", array("id"=>$item->country_id->id)) ?>" title="отелиистическая страна <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
            <?php if( $item->city_id ) : ?>город:<a href="<?= SiteHelper::createUrl("resorts/", array("category"=>$item->city_id->id)) ?>" title="<?= SiteHelper::getTranslateForUrl( $item->city_id->name ) ?>"><?= $item->city_id->name ?></a><br/><?php endif; ?>
            <br/>
            <a class="OrderRequest LPLink" href="#" title=Забронировать зону отдха <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>">забронировать</a><br/>
        </div>
        <?= $item->description ?>
        <div class="LParams">
            <p><b>Контактая информация:</b><br/><br/>
                <?php if( $item->telefon ) : ?>Телефон: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail: <a href="mailto:<?= $item->email ?>"><?= $item->email ?></a><br/><?php endif; ?>
                <?php if( $item->www ) : ?>Сайт: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                <br/><br/>
            </p>
            <a class="OrderRequest LPLink" href="#" title=Забронировать зону отдха <?= SiteHelper::getStringForTitle( $item->country_id->name ) ?>">забронировать</a>
        </div>
        <div id="orderInfo" class="displayNone">
            <b>Курортная зона отдха - <?= $item->name ?></b><br/>
            <p>Для бронирования или уточнения информации необходимо связатся хозяинов.</p>
            <p>
                <?php if( $item->telefon ) : ?>Телефон: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail: <a href="mailto:<?= $item->email ?>"><?= $item->email ?></a><br/><?php endif; ?>
                <?php if( $item->www ) : ?>Сайт: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a>
                </div>
            </p>
        </div>
    </div>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($otherHotels)>0 ) : ?>
        <h2>Другие зоны отдаха <?= $item->category_id->name ?></h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherHotels as $hotel ) : ?>
                <?php $this->widget("resortWidget", array( "item"=>$hotel )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("resorts/", array("category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item ))) ?>" class="cmore" title="все курорты <?= $item->category_id->name ?>">Смотреть все курорты - <?= $item->category_id->name ?> ( <?= $hotelCount ?> зон отдыха )...</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $this->endCache(); endif;?>