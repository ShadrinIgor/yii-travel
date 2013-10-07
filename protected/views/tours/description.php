<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Туристические странны"=>SiteHelper::createUrl("country/"),
        $item->name
    )
));
?>

<?php if( $this->beginCache( "tours_".$item->id, array('duration'=>3600) ) ) : ?>
<div id="InnerText">
    <h1><?= $item->name ?></h1>
    <div id="ITText" class="ITSmallText">
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="Туристическия странна <?= $item->name ?>" /></div><?php endif; ?>
        <?= $item->description ?>
    </div>
    <div class="hr">&nbsp;</div>
    <div class="textAlignRight">
        <a href="#" class="cmore ITextHref" title="">подробнее...</a>
    </div>
    <?php if( sizeof($tours)>0 ) : ?>
        <h2>Популярные туры <?= $item->name_2 ?></h2>
        <div class="ITBlock">
            <?php foreach( $tours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("tours/", array("country"=>$item->slug)) ?>" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все туры <?= $item->name_2 ?> ( <?= $tourCount ?> тура(ов) )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($firms)>0 ) : ?>
        <h2>Туристичесие фирмы <?= $item->name_2 ?></h2>
        <div class="hr">&nbsp;</div>
        <div class="ITBlock ITBFirms">
            <?php foreach( $firms as $firm ) : ?>
                <?php $this->widget("firmWidget", array( "item"=>$firm )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("firms/", array("country"=>$item->slug)) ?>" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все фирмы <?= $item->name_2 ?> ( <?= $firmCount ?> фирм )...</a>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php $this->endCache(); endif;?>