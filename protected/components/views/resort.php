<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("/resorts/description")."/".$item->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->name ) ?>"><img src="<?= ImageHelper::getImage($item->image, 2) ?>" alt="" /></a>
    </div>
    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров") ?>: <b><= $item->col ></b></div><?php endif; ?>
    <br/><a href="<?= SiteHelper::createUrl("/resorts/description")."/".$item->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->name ) ?>"><?= $item->name ?></a><br/>
    <div class="LParams">
        <?php if( $item->country_id ) : ?><?= $item->country_id->name ?><br/><?php endif; ?>
        <?php if( $item->category_id ) : ?><a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item->category_id->slug ?>.html" title="<?= Yii::t("page", "зоны отдыха"); ?> <?= $item->category_id->name ?>"><?= $item->category_id->name ?></a><?php endif; ?>
    </div>
</div>
