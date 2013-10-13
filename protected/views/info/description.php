<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "информация о туризме"=>SiteHelper::createUrl("info/"),
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
            <?php if( $item->country_id ) : ?>страна: <a href="<?= SiteHelper::createUrl("info/index", array("id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ))) ?>" title="отелиистическая страна <?= $item->country_id->name ?>"><?= $item->country_id->name ?></a><br/><?php endif; ?>
            <?php if( $item->category_id ) : ?>категория:<a href="<?= SiteHelper::createUrl("info/index", array("category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item->category_id ))) ?>" title="<?= $item->category_id->name ?>"><?= $item->category_id->name ?></a><br/><?php endif; ?>
            <br/>
        </div>
        <?= $item->description ?>
    </div>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($otherHotels)>0 ) : ?>
        <h2>Смотрите также</h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherHotels as $hotel ) : ?>
                <?php $this->widget("infoWidget", array( "item"=>$hotel )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("info/index", array("category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item->category_id ))) ?>" class="cmore" title="информация - <?= $item->category_id->name ?>">информация - <?= $item->category_id->name ?> ( <?= $hotelCount ?> записи )...</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $this->endCache(); endif;?>