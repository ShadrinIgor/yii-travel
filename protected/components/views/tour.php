<?php
if( !$tour->slug )
{
    $tour->slug = SiteHelper::getSlug( $tour );
}

$listImages = ImageHelper::getImages( $tour, 1 );
?>

<div class="IBItem IBTours">
    <?php if( $tour->price >0 ) : ?><p><?= Yii::t("page", "цена"); ?>:<b><?= $tour->price ?></b>у.е.</p><?php endif; ?>
    <?php if( $tour->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров") ?>: <b><?= $tour->col ?></b></div><?php endif; ?>
    <div class="IBIImage">
        <?php if( $tour->image ) : ?>
            <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $tour->name.",".$tour->category_id->name ) ?>"><img src="<?= ImageHelper::getImage($tour->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $tour->name.",".$tour->category_id->name ) ?>" /></a>
        <?php elseif( sizeof($listImages)>0 ) : ?>
            <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $tour->name.",".$tour->category_id->name ) ?>"><img src="<?= ImageHelper::getImage($listImages[0]->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $tour->name.",".$tour->category_id->name ) ?>" /></a>
        <?php endif; ?>
    </div>
    <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $tour->category_id->name.",".$tour->name ) ?>"><?= SiteHelper::getSubTextOnWorld( $tour->name, 100 ) ?></a><br/>
    <?= SiteHelper::getSubTextOnWorld( $tour->description, 150 ) ?>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$tour->firm_id->slug ?>.html" title="<?= Yii::t("page", "туристическая фирма"); ?> <?= SiteHelper::getStringForTitle( $tour->firm_id->name ) ?>"><?= $tour->firm_id->name ?></a>
    </div>
</div>
