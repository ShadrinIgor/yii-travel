<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("resorts/", array( "id"=>$item->id, "slug"=>SiteHelper::getSlug( $item ) )) ?>" title="<?= SiteHelper::getTranslateForUrl( $item->name ) ?>"><img src="<?= ImageHelper::getImage($item->image, 2) ?>" alt="" /></a>
    </div>
    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><= $item->col ></b></div><?php endif; ?>
    <br/><a href="<?= SiteHelper::createUrl("resorts/", array( "id"=>$item->id, "slug"=>SiteHelper::getSlug( $item ) )) ?>" title="<?= SiteHelper::getTranslateForUrl( $item->name ) ?>"><?= $item->name ?></a><br/>
    <div class="LParams">
        <?php if( $item->country_id ) : ?><a href="<?= SiteHelper::createUrl("resorts/index", array("country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ))) ?>" title="зоны отдаха <?= $item->country_id->name_2 ?>"><?= $item->country_id->name ?></b></a><br/><?php endif; ?>
        <?php if( $item->category_id ) : ?><a href="<?= SiteHelper::createUrl("resorts/index", array("category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item->category_id ))) ?>" title="курорты <?= $item->category_id->name ?>"><?= $item->category_id->name ?></b></a><?php endif; ?>
    </div>
</div>
