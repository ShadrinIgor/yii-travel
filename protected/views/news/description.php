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
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="<?= $item->name ?>" /></div><?php endif; ?>
        <?= $item->description ?>
    </div>
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