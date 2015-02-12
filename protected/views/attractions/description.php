<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "достопримечательности Узбекистана" =>SiteHelper::createUrl("/attractions"),
        "достопримечательности ".$item->city_id->name2 =>SiteHelper::createUrl("/attractions" ),
        $item->name
    )
));
?>

<div id="InnerText">
    <h1><?= $item->name ?></h1>
    <div id="ITText">
        <?php if( sizeof($images) >0 || $item->image ) : ?>
            <div class="floatLeft leftImages">
                <?php if( $item->image ) : ?><a href="<?= $item->image ?>" rel="lightbox" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><?php endif; ?>
                <?php foreach( $images as $image ) : ?>
                    <a href="<?= $image->image ?>" title="<?= $item->name." ".$image->name ?>" rel="lightbox"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" title="<?= $item->name." ".$image->name ?>" alt="<?= $item->name." ".$image->name ?>" /></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?= $item->description ?>
    </div>
    <br/>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <br/>
    <?php if( sizeof($other)>0 ) : ?>
        <h2>Смотрите также</h2>
        <div class="ITBlock ATTRBlock">
            <?php foreach( $other as $o_item ) : ?>
                <div class="WItems MIMaps">
                    <a href="" title="<?= $o_item->name ?>"><?= $o_item->name ?></a>
                    <div class="WIImage">
                        <a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $o_item->name ?>"><img src="<?= ImageHelper::getImage( $o_item->image, 2 ) ?>" alt="<?= $o_item->name ?>" /></a>
                    </div>
                    <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $o_item->name ?>,смотреть подробнее">смотреть подробнее</a></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>