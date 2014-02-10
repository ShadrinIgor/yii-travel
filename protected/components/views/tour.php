<?php
    if( empty( $tour->slug ) || !$tour->slug )
    {
        $tour->slug = SiteHelper::getTranslateForUrl( $tour->name );
        $tour->save();
    }
?>

<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>" title="<?= SiteHelper::getTranslateForUrl( $tour->name ) ?>"><img src="<?= ImageHelper::getImage($tour->image, 2) ?>" alt="<?= SiteHelper::getTranslateForUrl( $tour->name ) ?>" /></a>
    </div>
    <?php if( $tour->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $tour->col ?></b></div><?php endif; ?>
    <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>"" title="<?= SiteHelper::getTranslateForUrl( $tour->name ) ?>"><?= SiteHelper::getSubTextOnWorld( $tour->name, 100 ) ?></a><br/>
    <?php if( $tour->price >0 ) : ?><p>цена:<b><?= $tour->price ?></b>у.е.</p><?php endif; ?>
    <?= SiteHelper::getSubTextOnWorld( $tour->description, 150 ) ?>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("firms/index", array("id"=>$tour->firm_id->id, "slug"=>SiteHelper::getSlug( $tour->firm_id  ))) ?>" title="туристическая фирма <?= SiteHelper::getTranslateForUrl( $tour->firm_id->name ) ?>"><?= $tour->firm_id->name ?></a>
    </div>
</div>
