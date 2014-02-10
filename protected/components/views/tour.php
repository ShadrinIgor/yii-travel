<?php
    if( !$tour->slug )
    {
        $tour->slug = SiteHelper::getSlug( $tour );
    }
?>

<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>" title="<?= SiteHelper::getStringForTitle( $tour->name.",".$tour->category_id->name ) ?>"><img src="<?= ImageHelper::getImage($tour->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $tour->name.",".$tour->category_id->name ) ?>" /></a>
    </div>
    <?php if( $tour->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $tour->col ?></b></div><?php endif; ?>
    <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>" title="<?= SiteHelper::getStringForTitle( $tour->category_id->name.",".$tour->name ) ?>"><?= SiteHelper::getSubTextOnWorld( $tour->name, 100 ) ?></a><br/>
    <?php if( $tour->price >0 ) : ?><p>цена:<b><?= $tour->price ?></b>у.е.</p><?php endif; ?>
    <?= SiteHelper::getSubTextOnWorld( $tour->description, 150 ) ?>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("/firms")."/".$tour->firm_id->slug ?>" title="туристическая фирма <?= SiteHelper::getStringForTitle( $tour->firm_id->name ) ?>"><?= $tour->firm_id->name ?></a>
    </div>
</div>
