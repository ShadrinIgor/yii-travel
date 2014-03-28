<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Туристические странны"=>SiteHelper::createUrl("country/"),
        $item->name
    )
));
?>

<?php if( $this->beginCache( "country_".$item->id, array('duration'=>3600) ) ) : ?>
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
                <a href="<?= SiteHelper::createUrl("/tours/", array("country"=>$item->slug)) ?>.html" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все туры <?= $item->name_2 ?> ( <?= $tourCount ?> тура(ов) )...</a>
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
                <a href="<?= SiteHelper::createUrl("/travelAgency", array("country"=>$item->slug)) ?>.html" class="cmore" title="все туры <?= $item->name_2 ?>">Смотреть все фирмы <?= $item->name_2 ?> ( <?= $firmCount ?> фирм )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($otherCountry)>0 ) : ?>
        <h2>Другие странны</h2>
        <div class="hr">&nbsp;</div>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherCountry as $CItem ) :
                $tourCounts = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array(":country_id"=>$CItem->id) ) );
                ?>
                <div class="IBItem">
                    <div class="IBIImage">
                        <a href="<?= SiteHelper::createUrl("/country/description")."/".$CItem->slug ?>.html" title="<?= $CItem->name ?> - туристическая страна"><img src="<?= ImageHelper::getImage($CItem->image, 2) ?>" alt="<?= $CItem->name ?> - туризм" /></a>
                    </div>
                    <?php if( $tour->price >0 ) : ?><p><?= $CItem->price ?></p><?php endif; ?>
                    <br/><a href="<?= SiteHelper::createUrl("/country/description")."/".$CItem->slug ?>.html" title="<?= $CItem->name ?> - туристическая страна"><?= $CItem->name ?></a><br/>
                    <div class="LParams">
                        Просмотров: <b><?= $CItem->col>0 ? $CItem->col : 0 ?></b><br/>
                        Туров: <b><?= $tourCounts ?></b><br/>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?php $this->endCache(); endif;?>