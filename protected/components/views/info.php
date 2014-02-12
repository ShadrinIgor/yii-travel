<div class="IBItem">
    <?php if( $item->image ) : ?>
        <div class="IBIImage">
            <a href="<?= SiteHelper::createUrl("/touristInfo/description")."/".$item->slug ?>" title="<?= SiteHelper::getStringForTitle( $item->name ) ?>"><img src="<?= ImageHelper::getImage($item->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $item->name ) ?>" /></a>
        </div>
    <?php endif; ?>
    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
    <a href="<?= SiteHelper::createUrl("/touristInfo/description")."/".$item->slug ?>" title="<?= SiteHelper::getStringForTitle( $item->name ) ?>"><?= SiteHelper::getSubTextOnWorld( $item->name, 100 ) ?></a><br/>
    <?php if( !$item->image ) : ?>
        <div class="textAlignJustify">
            <?= SiteHelper::getSubTextOnWorld( $item->description, 200 ) ?>
        </div>
    <?php endif; ?>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("/touristInfo")."/".$item->category_id ?>" title="<?= $item->category_id->name ?>"><?= $item->category_id->name ?></a>
    </div>
</div>
