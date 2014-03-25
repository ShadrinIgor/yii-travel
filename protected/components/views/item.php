<?php
    if( !$item->slug )
    {
        $item->slug = SiteHelper::getSlug( $item );
    }

    $images = ImageHelper::getImages( $item, 1 );
?>

<div class="IBItem">
    <?php if( sizeof($images) >0 ) : ?>
        <div class="IBIImage">
            <a href="<?= SiteHelper::createUrl("/".$link."/description")."/".$item->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->name.",".$item->firm_id->name ) ?>"><img src="<?= ImageHelper::getImage($images[0]->image, 2) ?>" alt="<?= SiteHelper::getStringForTitle( $item->name.",".$item->firm_id->name ) ?>" /></a>
        </div>
    <?php endif; ?>
    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
    <a href="<?= SiteHelper::createUrl("/".$link."/description")."/".$item->slug ?>.html" title="<?= SiteHelper::getStringForTitle( $item->firm_id->name.",".$item->name ) ?>"><?= SiteHelper::getSubTextOnWorld( $item->name, 100 ) ?></a><br/>
    <?php if( $item->price >0 ) : ?><p>цена:<b><?= $item->price ?></b>у.е.</p><?php endif; ?>
    <?= SiteHelper::getSubTextOnWorld( $item->description, 150 ) ?>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="туристическая фирма <?= SiteHelper::getStringForTitle( $item->firm_id->name ) ?>"><?= $item->firm_id->name ?></a>
    </div>
</div>
