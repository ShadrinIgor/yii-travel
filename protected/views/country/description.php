<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "Туристические странны")=>SiteHelper::createUrl("country/"),
        $item->name
    )
));
?>

<?php if( $this->beginCache( "country_".$item->id, array('duration'=>3600) ) ) : ?>
<div id="InnerText">
    <h1><?= $item->name ?></h1>
    <div id="ITText" class="ITSmallText">
        <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="<?= Yii::t("page", "Туристическая странна"); ?> <?= $item->name ?>" /></div><?php endif; ?>
        <?= $item->description ?>
    </div>
    <div class="hr">&nbsp;</div>
    <div class="textAlignRight">
        <a href="#" class="cmore ITextHref" title=""><?= Yii::t("page", "подробнее..."); ?></a>
    </div>
    <?php if( sizeof($tours)>0 ) : ?>
        <h2><?= Yii::t("page", "Популярные туры"); ?> <?= $item->name_2 ?></h2>
        <div class="ITBlock">
            <?php foreach( $tours as $tour ) : ?>
                <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/tours/", array("country"=>$item->slug)) ?>.html" class="cmore" title="<?= Yii::t("page", "все туры"); ?> <?= $item->name_2 ?>"><?= Yii::t("page", "Смотреть все туры"); ?> <?= $item->name_2 ?> ( <?= $tourCount ?> <?= Yii::t("page", "тура(ов)"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($firms)>0 ) : ?>
        <h2><?= Yii::t("page", "Туристические фирмы"); ?> <?= $item->name_2 ?></h2>
        <div class="hr">&nbsp;</div>
        <div class="ITBlock ITBFirms">
            <?php foreach( $firms as $firm ) : ?>
                <?php $this->widget("firmWidget", array( "item"=>$firm )) ?>
            <?php endforeach; ?>
            <div class="textAlignRight">
                <a href="<?= SiteHelper::createUrl("/travelAgency", array("country"=>$item->slug)) ?>.html" class="cmore" title="<?= Yii::t("page", "все туры"); ?> <?= $item->name_2 ?>"><?= Yii::t("page", "Смотреть все фирмы"); ?> <?= $item->name_2 ?> ( <?= $firmCount ?> <?= Yii::t("page", "фирм"); ?> )...</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($otherCountry)>0 ) : ?>
        <h2><?= Yii::t("page", "Другие странны"); ?></h2>
        <div class="hr">&nbsp;</div>
        <div class="ITBlock ITBFirms ITBOthCountry">
            <?php foreach( $otherCountry as $CItem ) :
                $tourCounts = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array(":country_id"=>$CItem->id) ) );
                ?>
                <div class="IBItem">
                    <div class="IBIImage">
                        <a href="<?= SiteHelper::createUrl("/country/description")."/".$CItem->slug ?>.html" title="<?= $CItem->name ?> - <?= Yii::t("page", "Туристическая странна"); ?>"><img src="<?= ImageHelper::getImage($CItem->image, 2) ?>" alt="<?= $CItem->name ?> - <?= Yii::t("page", "туризм"); ?> /></a>
                    </div>
                    <?php if( $tour->price >0 ) : ?><p><?= $CItem->price ?></p><?php endif; ?>
                    <br/><a href="<?= SiteHelper::createUrl("/country/description")."/".$CItem->slug ?>.html" title="<?= $CItem->name ?> - <?= Yii::t("page", "Туристическая странна"); ?>"><?= $CItem->name ?></a><br/>
                    <div class="LParams">
                        <?= Yii::t("page", "Просмотров"); ?>: <b><?= $CItem->col>0 ? $CItem->col : 0 ?></b><br/>
                        <?= Yii::t("page", "Туров"); ?>: <b><?= $tourCounts ?></b><br/>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?php $this->endCache(); endif;?>