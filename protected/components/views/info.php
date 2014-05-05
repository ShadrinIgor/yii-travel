<div class="IBItem">
    <?php if( $item->image || sizeof( $images ) >0 ) : ?>
        <div class="IBIImage">
            <a href="<?= SiteHelper::createUrl("/".$link."/description")."/".$item->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->name ) ?>">
                <?php if( $item->image  ) : ?>
                    <img src="<?= ImageHelper::getImage($item->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $item->name ) ?>" />
                <?php else : ?>
                    <img src="<?= ImageHelper::getImage( $images[0]->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $item->name ) ?>" />
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>
    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
    <a href="<?= SiteHelper::createUrl("/".$link."/description")."/".$item->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->name ) ?>"><?= SiteHelper::getSubTextOnWorld( $item->name, 100 ) ?></a><br/>
    <?php if( !$item->image ) : ?>
        <div class="textAlignJustify">
            <?= SiteHelper::getSubTextOnWorld( $item->description, 200 ) ?>
        </div>
    <?php endif; ?>
    <?php if( $item->category_id ) : ?>
        <div class="LParams">
            <a href="<?= SiteHelper::createUrl("/".$link."")."/category/".$item->category_id->slug ?>.html" title="<?= $item->category_id->name ?>"><?= $item->category_id->name ?></a>
        </div>
    <?php endif; ?>
</div>
