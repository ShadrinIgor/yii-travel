<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "информация о туризме"=>SiteHelper::createUrl("/touristInfo"),
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
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="странна <?= $item->name ?>" /></div><?php endif; ?>
        <div class="LParams">
            <br/>
            <?php if( $item->country_id->id >0 ) : ?>страна: <a href="<?= SiteHelper::createUrl("/touristInfo", array("country"=>$item->country_id->slug)) ?>.html" title="<?= $item->country_id->name ?>"><?= $item->country_id->name ?></a><br/><?php endif; ?>
            <?php if( $item->category_id->id >0 ) : ?>категория:<a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item->category_id->slug)) ?>.html" title="<?= $item->category_id->name ?> - категория туристической информации"><?= $item->category_id->name ?></a><br/><?php endif; ?>
            <br/>
        </div>
        <?= $item->description ?>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"infoErrorNote" ) ); ?>

    <div class="hr">&nbsp;</div>

    <?php if( sizeof($other)>0 ) : ?>
        <h2>Смотрите также</h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $other as $hotel ) : ?>
                <?php $this->widget("infoOneWidget", array( "item"=>$hotel )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item->category_id->slug)) ?>.html" class="cmore" title="информация - <?= $item->category_id->name ?>">информация - <?= $item->category_id->name ?> ( <?= $hotelCount ?> записи )...</a>
            </div>
        </div>
    <?php endif; ?>
</div>