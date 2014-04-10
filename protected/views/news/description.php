<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "новости"=>SiteHelper::createUrl("/news"),
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
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
    <div class="hr">&nbsp;</div>

    <?php if( sizeof($other)>0 ) : ?>
        <h2>Другие новости</h2>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $other as $o_item ) : ?>
                <div class="IBItem">
                    <div class="IBIImage">
                        <a href="<?= SiteHelper::createUrl("/news/description")."/".$o_item->slug ?>.html" title="<?= $o_item->name ?>"><img src="<?= ImageHelper::getImage($o_item->image, 2) ?>" alt="<?= $o_item->name ?>" /></a>
                    </div>
                    <?php if( $o_item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><= $o_item->col ></b></div><?php endif; ?>
                    <br/><a href="<?= SiteHelper::createUrl("/news/description")."/".$o_item->slug ?>.html" title="<?= $o_item->name ?>"><?= $o_item->name ?></a><br/>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>